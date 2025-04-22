<div>
    <div class="d-flex justify-content-between align-items-end mb-4">
        {{-- 🔍 Пошук --}}
        <div class="input-group w-50">
            <input type="text" class="form-control" placeholder="Введіть назву або артикул..."
                   wire:model.defer="search">
            <button class="btn btn-outline-secondary" wire:click="$refresh">
                <i class="bi bi-search"></i> Пошук
            </button>
        </div>

        {{-- ↕️ Сортування --}}
        <div class="text-end">
            <label class="fw-bold d-block mb-1">Сортувати за:</label>
            <div class="btn-group" role="group">
                <button class="btn btn-outline-primary" wire:click="sortBy('name')">Назвою</button>
                <button class="btn btn-outline-primary" wire:click="sortBy('price')">Ціною</button>
                <button class="btn btn-outline-primary" wire:click="sortBy('stock')">Наявністю</button>
            </div>
        </div>
    </div>


    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100 d-flex flex-column">
                    <div style="height: 220px; overflow: hidden;">
                        <img src="{{ $product->getFirstMediaUrl('images') }}"
                             class="card-img-top"
                             alt="{{ $product->name }}"
                             style="object-fit: cover; height: 100%; width: 100%;">
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-truncate" title="{{ $product->name }}">{{ $product->name }}</h5>
                        <p class="card-text text-muted mb-2">{{ number_format($product->price, 2) }} грн</p>
                        <a href="{{ route('product', $product->id) }}" class="btn btn-primary mt-auto">Детальніше</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{ $products->links() }}
</div>
