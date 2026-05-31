<?php
namespace App\Models;

use Core\Database\Model;

class Product extends Model {
    protected string $table = 'products';
    protected array $fillable = ['name', 'description', 'price'];
    protected array $rules = [
        'name' => ['required', 'max:255'],
        'description' => ['required'],
        'price' => ['required', 'numeric'],
    ];

    public function validate(array $data): array {
        return parent::validate($data);
    }
}