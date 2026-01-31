<form action="{{ route('posts.store') }}" method="POST">
    @csrf
    <label for="title">Title:</label>
    <input type="text" id="title" name="title">
    <br>
    <label for="content">Content:</label>
    <input type="text" id="content" name="content">
    <br>
    <button type="submit">Create Post</button>
</form>