@extends('layout')

@section('content')
    <div class="d-flex justify-content-center mt-5">
        <div class="card p-4 w-100" style="max-width: 800px;">
            <div class="row g-0">

                <!-- Left side: Image -->
                <div class="col-md-4 d-flex align-items-center justify-content-center">
                    <img src="{{ $products->product_image ?? 'https://via.placeholder.com/150' }}"
                        class="img-fluid rounded-start" alt="Product Image">
                </div>

                <!-- Right side: Form -->
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Edit Product</h5>
                        <form action="{{ route('products.update', $products->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Product Name -->
                            <div class="mb-3">
                                <label for="product_name" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="product_name" name="product_name"
                                    value="{{ $products->product_name }}" required>
                            </div>

                            <!-- Product Price -->
                            <div class="mb-3">
                                <label for="product_price" class="form-label">Product Price</label>
                                <input type="number" class="no-spin form-control" id="product_price" name="product_price"
                                    value="{{ $products->product_price }}" required
                                    style="-moz-appearance:textfield; -webkit-appearance:none; margin:0;">
                            </div>
                            <input type="hidden" class="form-control" name="id" value="{{ $products->id }}">

                            <!-- Product Image Upload -->
                            {{-- <div class="mb-3">
                                <label for="product_image" class="form-label">Change Image</label>
                                <input type="file" class="form-control" id="product_image" name="product_image">
                            </div> --}}

                            <!-- Buttons -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Product</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
