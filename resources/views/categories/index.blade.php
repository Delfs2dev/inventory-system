@extends('layouts.app')

@section('content')
    <h3>Categories</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(Auth::user()->role === 'admin')
        <a href="{{ route('categories.create') }}" class="btn btn-success mb-2">Add Category</a>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>ID</th><th>Name</th><th></th>
        </tr>
        @foreach($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
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
