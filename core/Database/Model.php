<?php
namespace Core\Database;

abstract class Model {
    protected string $table;
    protected Connection $db;
    protected QueryBuilder $query;

    public function __construct(Connection $db) {
        $this->db = $db;
        $this->query = new QueryBuilder($db);
    }

    public function all(): array {
        return $this->query->table($this->table)->get();
    }

    public function find(int $id): array|null {
        return $this->query->table($this->table)->where('id', '=', $id)->first();
    }

    public function create(array $data): bool {
        return $this->query->table($this->table)->insert($data);
    }

    public function update(int $id, array $data): bool {
        return $this->query->table($this->table)->where('id', '=', $id)->update($data);
    }

    public function delete(int $id): bool {
        return $this->query->table($this->table)->where('id', '=', $id)->delete();
    }
}