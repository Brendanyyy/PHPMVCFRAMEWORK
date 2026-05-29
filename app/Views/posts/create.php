<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
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
            <h1>Create New Post</h1>
            <?php $errors = $errors ?? []; $old = $old ?? []; ?>
            <?php if (!empty($errors)): ?>
                <div class="form-errors">
                    <strong>Please fix the following errors:</strong>
                    <ul>
                        <?php foreach ($errors as $fieldErrors): ?>
                            <?php foreach ($fieldErrors as $message): ?>
                                <li><?= htmlspecialchars($message) ?></li>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form action="<?= APP_BASE_PATH ?>/posts" method="POST">
                <div class="form-group">
                    <label for="title">Post Title</label>
                    <input type="text" id="title" name="title" value="<?= htmlspecialchars($old['title'] ?? '') ?>" placeholder="Enter post title" required>
                </div>

                <div class="form-group">
                    <label for="content">Post Content</label>
                    <textarea id="content" name="content" placeholder="Write your post content here..." required><?= htmlspecialchars($old['content'] ?? '') ?></textarea>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Save Post</button>
                    <a href="<?= APP_BASE_PATH ?>/posts" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>