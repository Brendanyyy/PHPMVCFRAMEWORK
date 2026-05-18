<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Post</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="header-title">📝 Posts Manager</div>
            <nav class="header-nav">
                <a href="/posts">All Posts</a>
                <a href="/posts/create">Create Post</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="card">
            <h1><?= htmlspecialchars($post['title']) ?></h1>
            <div class="text-muted mb-2">ID: <?= htmlspecialchars($post['id']) ?></div>
            
            <div class="mt-4" style="line-height: 1.8; color: var(--text-color);">
                <?= nl2br(htmlspecialchars($post['content'])) ?>
            </div>

            <div class="button-group mt-4">
                <a href="/posts" class="btn btn-secondary">← Back to Posts</a>
                <a href="/posts/<?= $post['id'] ?>/edit" class="btn btn-primary">Edit Post</a>
                <form action="/posts/<?= $post['id'] ?>/delete" method="POST" style="flex: 1;">
                    <button type="submit" class="btn btn-danger" style="width: 100%;" onclick="return confirm('Are you sure you want to delete this post?')">Delete Post</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>