<?php

namespace App\Filament\Resources;

use App\Enums\DeliveryType;
use App\Enums\OrderStatus;
use App\Enums\PaymentType;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers\ItemsRelationManager;
use App\Models\Order;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('customer_name')->label('Customer name')
                   ->required(),
                TextInput::make('email')->label('Email')
                    ->required()
                    ->type('email'),
                TextInput::make('phone')->label('Phone')
                    ->required()
                    ->type('phone'),
                Select::make('delivery_type')->label('Delivery')
                    ->options(DeliveryType::options())
                    ->enum(DeliveryType::class)
                    ->required(),
                Select::make('payment_type')->label('Payment')
                    ->options(PaymentType::options())
                    ->enum(PaymentType::class)
                    ->required(),
                Select::make('status')->label('Status')
                    ->options(OrderStatus::options())
                    ->enum(OrderStatus::class)
                    ->required(),
                TextInput::make('total_price')->label('Total price')
                    ->readonly()
                    ->required()
                    ->type('number')
                    ->minValue(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer_name')->searchable(),
                Tables\Columns\TextColumn::make('delivery_type')->formatStateUsing(fn($state) => $state?->label()),
                Tables\Columns\TextColumn::make('payment_type')  ->formatStateUsing(fn($state) => $state?->label()),
                Tables\Columns\TextColumn::make('status') ->formatStateUsing(fn($state) => $state?->label())->sortable(),
                Tables\Columns\TextColumn::make('total_price')->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
