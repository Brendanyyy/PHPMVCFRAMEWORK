<?php
namespace Core\Database;

class QueryBuilder {
    private Connection $db;
    private string $table;
    private array $wheres = [];
    private array $bindings = [];

    public function __construct(Connection $db) {
        $this->db = $db;
    }

    public function table(string $table): self {
        $this->table = $table;
        return $this;
    }

    public function where(string $column, string $operator, $value): self {
        $this->wheres[] = "$column $operator :$column";
        $this->bindings[$column] = $value;
        return $this;
    }

    public function get(): array {
        $sql = "SELECT * FROM {$this->table}";
        if ($this->wheres) {
            $sql .= " WHERE " . implode(' AND ', $this->wheres);
        }
        return $this->db->query($sql, $this->bindings);
    }

    public function first(): array|null {
        $results = $this->get();
        return $results[0] ?? null;
    }

    public function insert(array $data): bool {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        return $this->db->execute($sql, $data);
    }

    public function update(array $data): bool {
        $sets = [];
        foreach ($data as $column => $value) {
            $sets[] = "$column = :$column";
        }
        $sql = "UPDATE {$this->table} SET " . implode(', ', $sets);
        if ($this->wheres) {
            $sql .= " WHERE " . implode(' AND ', $this->wheres);
        }
        $params = array_merge($data, $this->bindings);
        return $this->db->execute($sql, $params);
    }

    public function delete(): bool {
        $sql = "DELETE FROM {$this->table}";
        if ($this->wheres) {
            $sql .= " WHERE " . implode(' AND ', $this->wheres);
        }
        return $this->db->execute($sql, $this->bindings);
    }
}