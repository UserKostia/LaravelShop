@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Products</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Кнопка для створення нового продукту -->
    <a href="{{ route('products.create') }}" class="btn btn-success mb-4">Add New Product</a>

    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text">Price: ${{ $product->price }}</p>

                        <!-- Форма додавання до кошика -->
                        <form action="{{ route('carts.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="number" name="quantity" value="1" min="1" required>
                            <button type="submit" class="btn btn-primary">Buy</button>
                        </form>

                        <!-- Кнопка редагування -->
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>

                        <!-- Кнопка видалення -->
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
