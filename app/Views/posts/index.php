<?php /** @var array $posts */
$posts = $posts ?? []; ?>

<h1>All Posts</h1>
<a href="/posts/create">Create New Post</a>
<ul>
<?php foreach($posts as $p): ?>
    <li>
        <?= htmlspecialchars($p['title'] ?? '') ?>
        <a href="/posts/<?= htmlspecialchars($p['id'] ?? '') ?>/edit">Edit</a>
        <form action="/posts/<?= htmlspecialchars($p['id'] ?? '') ?>/delete" method="POST" style="display:inline;">
            <button type="submit">Delete</button>
        </form>
    </li>
<?php endforeach; ?>
</ul>