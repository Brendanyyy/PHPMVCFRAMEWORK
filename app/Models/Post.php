<?php
namespace App\Models;

use Core\Database\Model;

class Post extends Model {
    protected string $table = 'posts';
    protected array $fillable = ['title', 'content'];
    protected array $rules = [
        'title' => ['required', 'max:255'],
        'content' => ['required'],
    ];

    public function validate(array $data): array {
        return parent::validate($data);
    }
}