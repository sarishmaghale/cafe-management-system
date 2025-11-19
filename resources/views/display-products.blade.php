@extends('layout')

@section('content')
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#newProductModal">
        Add New Product
    </button>
    {{-- Display error/success message --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <!-- Modal -->
    <div class="modal fade" id="newProductModal" tabindex="-1" aria-labelledby="newProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">New Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Product Name:</label>
                            <input type="text" class="form-control" id="recipient-name" name="product_name">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Price:</label>
                            <input type="number" class="no-spin form-control" id="message-text" name="product_price"
                                placeholder="Rs. "></input>
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>


    {{-- display all products --}}
    <div class="row justify-content-center">
        <div class="col-md-10">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Price</th>
                        <th colspan="2" scope="col">Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">

                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>Rs. {{ $product->product_price }}</td>
                            {{-- trigger edit for target product --}}
                            <form action="{{ route('products.edit', $product->id) }}" method="Get">
                                @csrf
                                <td><button class="btn btn-secondary">Edit</button></td>
                            </form>
                            <form action="/delete-product" method=""></form>
                            @csrf
                            <td><button class="btn btn-danger">Delete</button></td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
