@extends('entry')
@section('content')
<h2>Add New Course</h2>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<form action="/courses/store" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Course Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Price:</label><br>
    <input type="number" name="price" required step="0.01"><br><br>

    <label>Rate:</label><br>
    <input type="number" name="rate" step="0.01"><br><br>

    <label>Enrolled Count:</label><br>
    <input type="number" name="enrolled"><br><br>

    <label>Publish Status:</label><br>
    <select name="publish_status" required>
        <option value="1">Published</option>
        <option value="0">Draft</option>
    </select><br><br>

    <label>Category Level:</label><br>
    <select name="level" required>
        @foreach($categories as $cat)
            <option value="{{ $cat->category_id }}">{{ $cat->category_name }}</option>
        @endforeach
    </select><br><br>

    <label>Time Average (minutes):</label><br>
    <input type="number" name="time_average"><br><br>

    <label>Description:</label><br>
    <textarea name="description"></textarea><br><br>

    <label>Image:</label><br>
    <input type="file" name="image"><br><br>

    <button type="submit">Create Course</button>
</form>

</body>
@endsection
