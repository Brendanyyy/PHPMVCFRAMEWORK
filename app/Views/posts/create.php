<h1>Create Post</h1>
<form action="/posts" method="POST">
    <label>Title:</label>
    <input type="text" name="title" required>
    <br>
    <label>Content:</label>
    <textarea name="content" required></textarea>
    <br>
    <button type="submit">Save</button>
</form>