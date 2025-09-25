@extends('layouts.app')

@section('content')
    <h3>Products</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(Auth::user()->role === 'admin')
        <a href="{{ route('products.create') }}" class="btn btn-success mb-2">Add Product</a>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th></th>
        </tr>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name }}</td>
            <td>₱{{ number_format($product->price, 2) }}</td>
            <td>{{ $product->stock }}</td>
            <td>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                @else
                    <span class="text-muted">View Only</span>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
@endsection
