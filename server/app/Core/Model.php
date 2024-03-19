<?php

namespace App\Core;

use PDOStatement;

abstract class Model
{
    private $fail;
    private string $sql;
    private string $terms = '';
    private string $base = '';
    private array $joins = [];
    private int $limit = 0;
    private string $orders = '';
    private string $groupBy = '';
    private array $params = [];

    public function __construct(
        private string $table,
        private array $guarded = [],
    ) {
    }

    public function execute()
    {
        try {
            $this->buildSql();

            $stmt = Connect::getInstance()->prepare($this->sql);

            if (count($this->params) > 0) {
                foreach ($this->filter($this->params) as $key => $value) {
                    $stmt->bindValue(":$key", $value);
                }
            }

            $stmt->execute();

            $this->resetAttributes();

            return $stmt;
        } catch (\PDOException $e) {
            $this->fail = $e->getMessage();
        }
    }

    private function buildSql(): void
    {
        $joins = implode(" ", $this->joins);
        $terms = !empty($this->terms) ? " WHERE {$this->terms}" : "";
        $groupBy = !empty($this->groupBy) ? " GROUP BY {$this->groupBy}" : "";
        $orders = !empty($this->orders) ? " {$this->orders}" : "";
        $limit = !empty($this->limit) ? " LIMIT {$this->limit}" : "";

        $this->sql = "{$this->base} {$joins}{$terms}{$groupBy}{$orders}{$limit}";
    }

    public function fail(): ?array
    {
        if (!empty($this->fail)) {
            return $this->fail;
        }

        return null;
    }

    public function create(array $data): PDOStatement
    {
        foreach (array_keys($this->guarded) as $value) {
            if (array_key_exists($value, $data)) {
                unset($data[$value]);
            }
        }

        $columns = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));

        $this->base = "INSERT INTO {$this->table} ({$columns}) VALUES ({$values})";

        $this->setParams($data);

        return $this->execute();
    }

    public function read(string $fields = "*"): self
    {
        $this->base = "SELECT {$fields} FROM {$this->table}";

        return $this;
    }

    public function update(array $data): self
    {
        $this->termsIsRequired();

        $dateSet = [];

        foreach ($data as $bind => $value) {
            $dateSet[] = "{$bind} = :{$bind}";
        }

        $dateSet = implode(", ", $dateSet);

        $this->base = "UPDATE {$this->table} SET {$dateSet}";

        return $this;
    }

    public function delete(): self
    {
        $this->termsIsRequired();

        $this->base = "DELETE {$this->table} FROM {$this->table}";

        return $this;
    }

    public function join(string $table, string $primaryKey, string $foreinKey): self
    {
        array_push($this->joins, "INNER JOIN {$table} ON {$primaryKey} = {$table}.{$foreinKey}");

        return $this;
    }

    public function leftJoin(string $table, string $primaryKey, string $foreinKey): self
    {
        array_push($this->joins, "LEFT JOIN {$table} ON {$primaryKey} = {$table}.{$foreinKey}");

        return $this;
    }

    public function rightJoin(string $table, string $primaryKey, string $foreinKey): self
    {
        array_push($this->joins, "RIGHT JOIN {$table} ON {$primaryKey} = {$table}.{$foreinKey}");

        return $this;
    }

    public function where(string $terms): self
    {
        if ($this->terms) {
            $this->terms = "{$this->terms} AND $terms";
        } else {
            $this->terms = $terms;
        }

        return $this;
    }

    public function whereOr(string $terms): self
    {
        $this->terms = "{$this->terms} OR $terms";

        return $this;
    }

    public function setParams(array $params): self
    {
        $this->params = $params;

        return $this;
    }

    private function termsIsRequired(): void
    {
        if (!$this->terms) {
            throw new \Exception('Condições não definidas para executar a query.');
        }
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function orderBy(array $orders, string $sort = 'DESC'): self
    {
        $orders = implode(", ", array_values($orders));

        $this->orders = "ORDER BY {$orders} {$sort}";

        return $this;
    }

    public function groupBy(string $group): self
    {
        $this->groupBy = $group;

        return $this;
    }

    private function resetAttributes(): void
    {
        $this->joins = [];
        $this->terms = '';
        $this->groupBy = '';
        $this->orders = '';
        $this->limit = 0;
    }

    private function filter(array $data): ?array
    {
        $filter = [];
        foreach ($data as $key => $value) {
            $filter[$key] = (is_null($value) ? null : filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS));
        }
        return $filter;
    }
}
