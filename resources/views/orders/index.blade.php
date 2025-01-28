<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ordrs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
        <h1>Your Orders</h1>
        
        @if ($orders->isEmpty())
            <p>You have no orders yet.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order ID</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->id }}</td>
                            <td>${{ number_format($order->total_price, 2) }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>{{ ($order->created_at)?date('Y-m-d H:i',strtotime($order->created_at)):'' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
    </div>
</x-app-layout>
