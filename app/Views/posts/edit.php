<?php /** @var array|null $post */
$post = $post ?? null; ?>

<h1>Edit Post</h1>
<form action="/posts/<?= htmlspecialchars($post['id'] ?? '') ?>/update" method="POST">
    <label>Title:</label>
    <input type="text" name="title" value="<?= htmlspecialchars($post['title'] ?? '') ?>" required>
    <br>
    <label>Content:</label>
    <textarea name="content" required><?= htmlspecialchars($post['content'] ?? '') ?></textarea>
    <br>
    <button type="submit">Update</button>
</form>