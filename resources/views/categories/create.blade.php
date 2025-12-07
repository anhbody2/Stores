@extends('entry')
@section('content')
<h2>Add New Category</h2>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<form action="/categories/store" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Category Name:</label><br>
    <input type="text" name="category_name" required><br><br>

    <label>Description:</label><br>
    <textarea name="description"></textarea><br><br>

    <label>Image:</label><br>
    <input type="file" name="image"><br><br>

    <button type="submit">Create Category</button>
</form>

</body>
@endsection
