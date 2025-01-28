<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
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
    <div class="container">
    <div class="col-md-12">
        <div class="my-4">
            <h2>Product Listing</h2>
            @if (session('message'))
                <div class="alert">{{ session('message') }}</div>
            @endif
        </div>
        <!-- Search Bar -->
        <div class="input-group mb-4">
            <input type="text" class="form-control" id="search" placeholder="Search for products">
            <button class="btn btn-primary" id="search-btn">Search</button> &nbsp;
            <a href="{{url('/cart')}}" class="btn btn-primary">Cart</a>
        </div>

        <!-- Product Grid -->
        <div class="row" id="product-list">
            <!-- Products will be loaded here dynamically -->
        </div>
    </div>
    </div>
</x-app-layout>
<script>
        function loadProducts(query = "") {
                $.ajax({
                    url: "<?php echo url('api/products');?>",
                    method: "GET",
                    data: { query: query },
                    success: function (response) {
                        const productContainer = $("#product-list");
                        productContainer.empty();

                        if (response.length === 0) {
                            productContainer.append("<p class='text-center'>No products found</p>");
                        } else {
                            response.forEach(product => {
                                productContainer.append(`
                                    <div class="col-md-4 mb-4">
                                        <div class="product-card">
                                            <h5>${product.name}</h5>
                                            <p>${product.description}</p>
                                            <p><strong>$${product.price}</strong></p>
                                            <button class="addTocart btn btn-success" onclick="addTocart(${product.id})">Add to Cart</button>
                                            
                                        </div>
                                    </div>
                                `);
                            });
                        }
                    },
                    error: function () {
                        alert("Failed to load products.");
                    }
                });
            }

            // Initial load
            loadProducts();

            // Search functionality
            $("#search-btn").click(function () {
                const query = $("#search").val();
                loadProducts(query);
            });
            function deletePro(id)
            {
                if(confirm('Do you sure'))
                {
                    $.ajax({
                            url: "<?php echo url('api/products');?>/"+id,
                            type: 'DELETE',
                            method: "DELETE",
                            success: function (response) {
                                loadProducts();
                            }
                        });
                }
            }
            function addTocart(id)
            {
                $.ajax({
                            url: "<?php echo url('cart/add');?>",
                            method: "post",
                            data:{"_token": "{{ csrf_token() }}","id": id},
                            success: function (response) {
                                alert('Added');
                            }
                        });
            }
    </script>
