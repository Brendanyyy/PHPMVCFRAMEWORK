<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Posts</title>
    <link rel="stylesheet" href="<?= APP_BASE_PATH ?>/css/style.css">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="header-title">Posts Manager</div>
            <!-- <nav class="header-nav">
                <a href="<?= APP_BASE_PATH ?>/posts">All Posts</a>
                <a href="<?= APP_BASE_PATH ?>/posts/create">Create Post</a>
            </nav> -->
        </div>
    </header>

    <div class="container">
        <div class="card">
            <h1>All Posts</h1>
            <?php /** @var array $posts */
            $posts = $posts ?? []; ?>
            
            <?php if (empty($posts)): ?>
                <div class="empty-state">
                    <h3>No posts yet</h3>
                    <p class="text-muted">Start by creating your first post.</p>
                    <a href="<?= APP_BASE_PATH ?>/posts/create" class="btn btn-primary mt-4">Create New Post</a>
                </div>
            <?php else: ?>
                <div class="mb-2">
                    <a href="<?= APP_BASE_PATH ?>/posts/create" class="btn btn-primary">+ Create New Post</a>
                </div>
                <ul class="post-list">
                    <?php foreach($posts as $p): ?>
                        <li class="post-item">
                            <div>
                                <div class="post-item-title"><?= htmlspecialchars($p['title'] ?? '') ?></div>
                                <small class="text-muted">ID: <?= htmlspecialchars($p['id'] ?? '') ?></small>
                            </div>
                            <div class="post-actions">
                                <a href="<?= APP_BASE_PATH ?>/posts/<?= htmlspecialchars($p['id'] ?? '') ?>/edit" class="btn btn-secondary">Edit</a>
                                <form action="<?= APP_BASE_PATH ?>/posts/<?= htmlspecialchars($p['id'] ?? '') ?>/delete" method="POST">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>