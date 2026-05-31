<?php
namespace App\Controllers;

use App\Models\Product;
use Core\Http\Request;
use Core\View\Engine;

class ProductController {
    private Product $productModel;
    private Engine $view;

    public function __construct(Product $productModel, Engine $view) {
        $this->productModel = $productModel;
        $this->view = $view;
    }

    public function index(): void {
        $products = $this->productModel->all();
        $this->view->render('products/index', ['products' => $products]);
    }

    public function create(): void {
        $this->view->render('products/create', ['errors' => [], 'old' => []]);
    }

    public function store(Request $request): void {
        $data = $request->all();
        $errors = $this->productModel->validate($data);

        if (!empty($errors)) {
            $this->view->render('products/create', [
                'errors' => $errors,
                'old' => $data,
            ]);
            return;
        }

        $this->productModel->create($data);
        header('Location: ' . APP_BASE_PATH . '/products');
        exit;
    }

    public function edit(int $id): void {
        $product = $this->productModel->find($id);
        if ($product === null) {
            throw new \Exception('Product not found');
        }

        $this->view->render('products/edit', ['product' => $product, 'errors' => [], 'old' => []]);
    }

    public function update(int $id, Request $request): void {
        $product = $this->productModel->find($id);
        if ($product === null) {
            throw new \Exception('Product not found');
        }

        $data = $request->all();
        $errors = $this->productModel->validate($data);

        if (!empty($errors)) {
            $this->view->render('products/edit', [
                'product' => $product,
                'errors' => $errors,
                'old' => $data,
            ]);
            return;
        }

        $this->productModel->update($id, $data);
        header('Location: ' . APP_BASE_PATH . '/products');
        exit;
    }

    public function delete(int $id): void {
        $this->productModel->delete($id);
        header('Location: ' . APP_BASE_PATH . '/products');
        exit;
    }
}