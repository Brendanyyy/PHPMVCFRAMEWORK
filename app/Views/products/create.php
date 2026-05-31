<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
    <link rel="stylesheet" href="<?= APP_BASE_PATH ?>/css/style.css">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="header-title">Products Manager</div>
        </div>
    </header>

    <div class="container">
        <div class="card">
            <h1>Create New Product</h1>
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
            <form action="<?= APP_BASE_PATH ?>/products" method="POST">
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>" placeholder="Enter product name" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Write product details here..." required><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" id="price" name="price" value="<?= htmlspecialchars($old['price'] ?? '') ?>" placeholder="e.g. 99.99" required>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Save Product</button>
                    <a href="<?= APP_BASE_PATH ?>/products" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>