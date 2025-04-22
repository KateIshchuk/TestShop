<div class="container my-4">
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6 mb-3">
            @php
                $imageUrl = $product->getFirstMediaUrl('images');
            @endphp
            @if($imageUrl)
                <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="img-fluid rounded">
            @else
                <img src="{{ asset('images/no-image.png') }}" alt="No image" class="img-fluid rounded">
            @endif
        </div>

        <div class="col-md-6">
            <h1 class="mb-3">{{ $product->name }}</h1>
            <p class="h4 text-success">{{ $product->price }} грн</p>
            @if($product->description)
                <div class="mb-3">
                    <p>{{ $product->description }}</p>
                </div>
            @endif
            <button wire:click="addToCart" class="btn btn-primary">
                Додати в кошик
            </button>
        </div>
    </div>
</div>

