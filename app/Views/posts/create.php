<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="header-title">Posts Manager</div>
            <nav class="header-nav">
                <a href="/posts">All Posts</a>
                <a href="/posts/create">Create Post</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="card">
            <h1>Create New Post</h1>
            <form action="/posts" method="POST">
                <div class="form-group">
                    <label for="title">Post Title</label>
                    <input type="text" id="title" name="title" placeholder="Enter post title" required>
                </div>

                <div class="form-group">
                    <label for="content">Post Content</label>
                    <textarea id="content" name="content" placeholder="Write your post content here..." required></textarea>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Save Post</button>
                    <a href="/posts" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>