<form action="{{ route('posts.update', $post->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" value="{{$post->title}}">
    <br>
    <label for="content">Content:</label>
    <input type="text" id="content" name="content" value="{{$post->content}}">
    <br>
    <button type="submit">Update Post</button>
</form>