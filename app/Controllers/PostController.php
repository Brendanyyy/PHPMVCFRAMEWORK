<?php
namespace App\Controllers;

use App\Models\Post;
use Core\View\Engine;

class PostController {
    private Post $postModel;
    private Engine $view;

    public function __construct(Post $postModel, Engine $view) {
        $this->postModel = $postModel;
        $this->view = $view;
    }

    public function index() {
        $posts = $this->postModel->all();
        $this->view->render('posts/index', ['posts' => $posts]);
    }

    public function create() {
        $this->view->render('posts/create', ['errors' => [], 'old' => []]);
    }

    public function store(\Core\Http\Request $request) {
        $data = $request->all();
        $errors = $this->postModel->validate($data);

        if (!empty($errors)) {
            $this->view->render('posts/create', [
                'errors' => $errors,
                'old' => $data,
            ]);
            return;
        }

        $this->postModel->create($data);
        header('Location: ' . APP_BASE_PATH . '/posts');
        exit;
    }

    public function edit(int $id) {
        $post = $this->postModel->find($id);
        $this->view->render('posts/edit', ['post' => $post, 'errors' => [], 'old' => []]);
    }

    public function update(int $id, \Core\Http\Request $request) {
        $post = $this->postModel->find($id);
        if ($post === null) {
            throw new \Exception('Post not found');
        }

        $data = $request->all();
        $errors = $this->postModel->validate($data);

        if (!empty($errors)) {
            $this->view->render('posts/edit', [
                'post' => $post,
                'errors' => $errors,
                'old' => $data,
            ]);
            return;
        }

        $this->postModel->update($id, $data);
        header('Location: ' . APP_BASE_PATH . '/posts');
        exit;
    }

    public function delete(int $id) {
        $this->postModel->delete($id);
        header('Location: ' . APP_BASE_PATH . '/posts');
        exit;
    }
}