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
        $this->view->render('posts/create');
    }

    public function store(\Core\Http\Request $request) {
        $this->postModel->create($request->all());
        header('Location: /posts');
    }

    public function edit(int $id) {
        $post = $this->postModel->find($id);
        $this->view->render('posts/edit', ['post' => $post]);
    }

    public function update(int $id, \Core\Http\Request $request) {
        $this->postModel->update($id, $request->all());
        header('Location: /posts');
    }

    public function delete(int $id) {
        $this->postModel->delete($id);
        header('Location: /posts');
    }
}