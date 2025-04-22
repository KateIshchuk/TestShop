<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('quantity')
                    ->type('number'),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Order Items')
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Name'),
                Tables\Columns\TextColumn::make('price')->label('Price')->money('uah', true),
                Tables\Columns\TextColumn::make('quantity')->label('Quantity'),
                Tables\Columns\TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->getStateUsing(fn($record) => $record->price * $record->quantity)
                    ->money('uah', true),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()
                    ->form(fn(Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\TextInput::make('quantity')->numeric()->minValue(1)->required(),
                    ])
                    ->after(fn($record, $data) => $this->handleAttachProduct($record, $data)),
            ])
            ->actions([
                Tables\Actions\DetachAction::make()
                    ->after(fn($record) => $this->handleDetachProduct($record)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);

    }
    private function handleAttachProduct($record, $data)
    {
        $product = \App\Models\Product::where('id', $record->id)->lockForUpdate()->first();
        $qty = (int) $data['quantity'];

        if (! $this->isStockAvailable($product, $qty)) {
            Notification::make()
                ->title('Недостатньо товару')
                ->body("Доступно лише {$product->stock} шт.")
                ->danger()
                ->send();
            $this->ownerRecord->items()->detach($product->id);
            return;
        }
        $this->deductProductStock($product, $qty);
        $this->updateOrderAmount();

    }
    private function handleDetachProduct($record): void
    {
        $qty = $record->pivot->quantity;
        $record->increment('stock', $qty);
        $this->updateOrderAmount();

    }

    private function isStockAvailable($product, int $qty): bool
    {
        return $product->stock >= $qty;
    }
    private function deductProductStock($product, int $qty): void
    {
        $product->decrement('stock', $qty);
    }
    private function updateOrderAmount(): void
    {
        $this->ownerRecord->total_price = $this->ownerRecord->items->sum(fn(Product $product) => $product->price * $product->pivot->quantity);
        $this->ownerRecord->save();

        $this->ownerRecord->refresh();
        $this->dispatch('productsChanged');
    }
}
