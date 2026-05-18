<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'My MVC Framework'; ?></title>
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
        <?php echo $content ?? ''; ?>
    </div>
</body>
</html>
