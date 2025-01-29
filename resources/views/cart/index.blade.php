<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content -->
    <div class="container my-5">
    <h1>Shopping Cart</h1>
    <table class="table">
        <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="cart-items">
        @php $total = 0; @endphp
        @foreach($cart as $id => $item)
            <tr data-id="{{ $id }}">
                <td>{{ $item['name'] }}</td>
                <td>${{ number_format($item['price'], 2) }}</td>
                <td>
                    <input type="number" class="form-control quantity" value="{{ $item['quantity'] }}" min="1">
                </td>
                <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                <td>
                    <button class="btn btn-danger btn-sm remove-btn">Remove</button>
                </td>
            </tr>
            @php $total += $item['price'] * $item['quantity']; @endphp
        @endforeach
        </tbody>
    </table>
    <h3>Total: $<span id="cart-total">{{ number_format($total, 2) }}</span></h3>
    <a href="{{url('/checkout')}}" class="btn btn-primary">Checkout</a>
</div>

<script>
    // Update cart quantity
    $(document).on('change', '.quantity', function () {
        const row = $(this).closest('tr');
        const productId = row.data('id');
        const quantity = $(this).val();

        $.ajax({
            url: "{{ route('cart.update') }}",
            method: "POST",
            data: {
                id: productId,
                quantity: quantity,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                location.reload(); // Reload the page to reflect changes
            },
            error: function () {
                alert("Failed to update the cart.");
            }
        });
    });

    // Remove product from cart
    $(document).on('click', '.remove-btn', function () {
        const row = $(this).closest('tr');
        const productId = row.data('id');

        $.ajax({
            url: "{{ route('cart.remove') }}",
            method: "POST",
            data: {
                id: productId,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                location.reload(); // Reload the page to reflect changes
            },
            error: function () {
                alert("Failed to remove the product.");
            }
        });
    });
</script>
</x-app-layout>