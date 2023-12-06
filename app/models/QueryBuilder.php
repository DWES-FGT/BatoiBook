<?php

namespace app\models;

use mysqli;

class QueryBuilder
{
    protected $db_host = DB_HOST;
    protected $db_user = DB_USER;
    protected $db_pass = DB_PASS;
    protected $db_name = DB_NAME;
    protected $table;
    protected $query;
    protected $select = '*';
    protected $where, $values = [];
    protected $orderBy = '';
    protected $connection;

    public function __construct(string $table)
    {
        echo "OK";
        $this->table = $table;
        $this->connection();
    }

    public function connection()
    {
        // Create connection
        $this->connection = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name) or die("Connect failed: %s\n" . $this->connection->error);
    }

    public function query(string $sql, array $data = [], $params = null)
    {
        if ($data) {
            if ($params == null) {
                $params = str_repeat('s', count($data));
            }
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param($params, ...$data);
            $stmt->execute();

            $this->query = $stmt->get_result();
        } else {
            $this->query = $this->connection->query($sql);
        }

        return $this;
    }

    public function where(string $colum, string $operator, $value = null)
    {
        // Con 3 params
        // SELECT * FROM tabla WHERE $column $operator '$value'

        // Con 2 params
        // SELECT * FROM tabla WHERE $column = '$value'
        if ($value == null) {
            $value = $operator;
            $operator = "=";
        }

        if ($this->where) {
            $this->where .= " AND {$colum} {$operator} ? ";
        } else {
            $this->where = "{$colum} {$operator} ?";
        }

        $this->values[] = $value;

        return $this;
    }

    public function orderBy(string $colum, string $order = 'ASC')
    {
        if ($this->orderBy) {
            $this->orderBy .= ", {$colum} {$order}";
        } else {
            $this->orderBy = "{$colum} {$order}";
        }

        return $this;
    }

    public function first()
    {
        if (empty($this->query)) {
            $sql = "SELECT {$this->select} FROM {$this->table}";

            if ($this->where) {
                $sql .= " WHERE {$this->where}";
            }

            if ($this->orderBy) {
                $sql .= " ORDER BY {$this->orderBy}";
            }
            $this->query($sql, $this->values);
        }
        return $this->query->fetch_assoc();
    }

    public function get()
    {
        if (empty($this->query)) {
            $sql = "SELECT {$this->select} FROM {$this->table}";

            if ($this->where) {
                $sql .= " WHERE {$this->where}";
            }

            if ($this->orderBy) {
                $sql .= " ORDER BY {$this->orderBy}";
            }
            $this->query($sql, $this->values);
        }
        return $this->query->fetch_all(MYSQLI_ASSOC);
    }

    public function paginate(int $cant = 10)
    {
        $page = $_GET['page'] ?? 1;

        if (empty($this->query)) {
            $sql = "SELECT {$this->select} FROM {$this->table}";

            if ($this->where) {
                $sql .= " WHERE {$this->where}";
            }

            if ($this->orderBy) {
                $sql .= " ORDER BY {$this->orderBy}";
            }

            $sql .= " LIMIT " . ($page - 1) * $cant . ", $cant";

            $data = $this->query($sql, $this->values)->get();
        }

        $total = $this->query("SELECT FOUND_ROWS() as total")->first()['total'];

        $uri = $_SERVER['REQUEST_URI'];
        $uri = trim($uri, '/');
        if (strpos($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }

        $last_page = ceil($total / $cant);

        return [
            'total' => $total,
            'from' => ($page - 1) * $cant + 1,
            'to' => ($page - 1) * $cant + count($data),
            'current_page' => $page,
            'last_page' => $last_page,
            'next_page_url' => $page < $last_page ? "/" . $uri . "?page=" . $page + 1 : null,
            'prev_page_url' => $page >= 2 ? "/" . $uri . "?page=" . $page - 1 : null,
            'uri' => $uri,
            'data' => $data
        ];
    }

    // Consultas
    public function all()
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->query($sql)->get();
    }

    public function find(int $id)
    {
        // SELECT * FROM {$this->table} WHERE id = 3;
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->query($sql, [$id], 'i')->first();
    }

    // Insertar registros
    public function create(array $data)
    {
        // INSERT INTO tabla VALUES (?, ?, ?, ?)
        $columns = array_keys($data);
        $columns = implode(', ', $columns);
        $values = array_values($data);

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES (" . str_repeat('?, ', count($values) - 1) . "?)";
        $this->query($sql, $values);

        $insertId = $this->connection->insert_id;
        return $this->find($insertId);
    }

    // Actualizar registro
    public function update(int $id, array $data)
    {
        // UPDATE table SET name = ?, email = ?, phone = ? WHERE id = '$id';
        $fields = [];

        foreach ($data as $key => $value) {
            $fields[] = "{$key} = ?";
        }

        $fields = implode(", ", $fields);
        $sql = "UPDATE {$this->table} SET {$fields} WHERE id = ?";

        $values = array_values($data);
        $values[] = $id;

        $this->query($sql, $values);
        return $this->find($id);
    }

    // Eliminar registro
    public function delete(int $id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $this->query($sql, [$id], 'i');
    }

}