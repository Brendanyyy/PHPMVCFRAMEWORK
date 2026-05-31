<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products</title>
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
            <h1>All Products</h1>
            <?php /** @var array $products */
            $products = $products ?? []; ?>

            <?php if (empty($products)): ?>
                <div class="empty-state">
                    <h3>No products yet</h3>
                    <p class="text-muted">Start by creating your first product.</p>
                    <a href="<?= APP_BASE_PATH ?>/products/create" class="btn btn-primary mt-4">Create New Product</a>
                </div>
            <?php else: ?>
                <div class="mb-2">
                    <a href="<?= APP_BASE_PATH ?>/products/create" class="btn btn-primary">+ Create New Product</a>
                </div>
                <ul class="post-list">
                    <?php foreach ($products as $product): ?>
                        <li class="post-item">
                            <div>
                                <div class="post-item-title"><?= htmlspecialchars($product['name'] ?? '') ?></div>
                                <small class="text-muted">Price: $<?= htmlspecialchars($product['price'] ?? '') ?></small>
                            </div>
                            <div class="post-actions">
                                <a href="<?= APP_BASE_PATH ?>/products/<?= htmlspecialchars($product['id'] ?? '') ?>/edit" class="btn btn-secondary">Edit</a>
                                <form action="<?= APP_BASE_PATH ?>/products/<?= htmlspecialchars($product['id'] ?? '') ?>/delete" method="POST">
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