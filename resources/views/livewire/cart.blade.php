
    <div>
        <h1 class="mb-4">Ваш кошик</h1>

        @if(empty($cartItems))
            <div class="alert alert-warning">Ваш кошик порожній.</div>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th>Товар</th>
                    <th>Ціна</th>
                    <th>Кількість</th>
                    <th>Сума</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($cartItems as $productId => $item)
                    <tr>
                        <td>{{ $item['product']->name }}</td>
                        <td>{{ number_format($item['product']->price, 2) }} грн</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-secondary"
                                        wire:click="decrement({{ $productId }})">−
                                </button>
                                <span class="px-2">{{ $item['quantity'] }}</span>
                                <button class="btn btn-sm btn-outline-secondary"
                                        wire:click="increment({{ $productId }})">+
                                </button>
                            </div>
                        </td>
                        <td>{{ number_format($item['product']->price * $item['quantity'], 2) }} грн</td>
                        <td>
                            <button class="btn btn-sm btn-danger" wire:click="remove({{ $productId }})">×</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-between">
                <h4>Загальна сума: {{ number_format($this->getTotal(), 2) }} грн</h4>
                <a href="{{ route('checkout') }}" class="btn btn-success">Оформити замовлення</a>
            </div>
        @endif
    </div>

