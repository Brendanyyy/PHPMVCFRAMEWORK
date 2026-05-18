<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
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
            <?php /** @var array|null $post */
            $post = $post ?? null; ?>
            
            <h1>Edit Post</h1>
            <form action="/posts/<?= htmlspecialchars($post['id'] ?? '') ?>/update" method="POST">
                <div class="form-group">
                    <label for="title">Post Title</label>
                    <input type="text" id="title" name="title" value="<?= htmlspecialchars($post['title'] ?? '') ?>" placeholder="Enter post title" required>
                </div>

                <div class="form-group">
                    <label for="content">Post Content</label>
                    <textarea id="content" name="content" placeholder="Write your post content here..." required><?= htmlspecialchars($post['content'] ?? '') ?></textarea>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Update Post</button>
                    <a href="/posts" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>