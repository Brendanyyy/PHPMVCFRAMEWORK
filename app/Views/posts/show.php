<h1><?= htmlspecialchars($post['title']) ?></h1>
<p><?= nl2br(htmlspecialchars($post['content'])) ?></p>

<a href="/posts">Back to all posts</a>
<a href="/posts/<?= $post['id'] ?>/edit">Edit Post</a>

<form action="/posts/<?= $post['id'] ?>/delete" method="POST" style="display:inline;">
    <button type="submit">Delete Post</button>
</form>