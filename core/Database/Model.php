<?php
namespace Core\Database;

use Core\Validation\Validator;

abstract class Model {
    protected string $table;
    protected array $fillable = [];
    protected array $rules = [];
    protected Connection $db;
    protected QueryBuilder $query;
    protected Validator $validator;

    public function __construct(Connection $db) {
        $this->db = $db;
        $this->query = new QueryBuilder($db);
        $this->validator = new Validator();
    }

    public function all(): array {
        return $this->query->table($this->table)->get();
    }

    public function find(int $id): array|null {
        return $this->query->table($this->table)->where('id', '=', $id)->first();
    }

    public function validate(array $data): array {
        return $this->validator->validate($data, $this->rules);
    }

    public function create(array $data): bool {
        return $this->query->table($this->table)->insert($this->filterFillable($data));
    }

    public function update(int $id, array $data): bool {
        return $this->query->table($this->table)->where('id', '=', $id)->update($this->filterFillable($data));
    }

    public function delete(int $id): bool {
        return $this->query->table($this->table)->where('id', '=', $id)->delete();
    }

    protected function filterFillable(array $data): array {
        if (empty($this->fillable)) {
            return $data;
        }

        return array_intersect_key($data, array_flip($this->fillable));
    }
}