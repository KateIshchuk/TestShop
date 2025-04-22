<div>
    <h1 class="mb-4">Оформлення замовлення</h1>

    @if (session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form wire:submit.prevent="placeOrder">
        <div class="mb-3">
            <label class="form-label">ПІБ <span class="text-danger">*</span></label>
            <input type="text" class="form-control" wire:model="name">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" wire:model="email">
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Телефон <span class="text-danger">*</span></label>
            <input type="tel" class="form-control" wire:model="phone">
            @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Спосіб доставки <span class="text-danger">*</span></label>
            <select class="form-select" wire:model="deliveryType">
                @foreach ($this->deliveryOptions as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Оплата <span class="text-danger">*</span></label>
            <select class="form-select" wire:model="paymentType">
                @foreach ($this->paymentOptions as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success">Підтвердити замовлення</button>
    </form>

</div>
