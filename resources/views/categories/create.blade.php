<!-- resources/views/categories/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Category</h1>
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Add Category</button>
    </form>
</div>
@endsection
