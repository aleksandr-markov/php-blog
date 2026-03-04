<?php

namespace PHPFramework;

use Valitron\Validator;

class Model
{
    protected string $table;
    public bool $timestamps = true;
    protected array $loaded = [];
    protected array $fillable = [];
    public array $attributes = [];
    protected array $rules = [];
    protected array $labels = [];
    protected array $errors = [];

    public function save(): false|string
    {
        foreach ($this->attributes as $k => $v) {
            if (!in_array($k, $this->fillable)) {
                unset($this->attributes[$k]);
            }
        }

        $fieldsKeys = array_keys($this->attributes);
        $fields = array_map(fn($field) => "`{$field}`", $fieldsKeys);
        $fields = implode(',', $fields);
        if ($this->timestamps) {
            $fields .= ', `created_at`, `updated_at`';
        }

        $placeholders = array_map(fn($field) => ":{$field}", $fieldsKeys);
        $placeholders = implode(',', $placeholders);
        if ($this->timestamps) {
            $placeholders .= ', :created_at, :updated_at';
            $this->attributes['created_at'] = date("Y-m-d H:i:s");
            $this->attributes['updated_at'] = date("Y-m-d H:i:s");
        }

        $query = "insert into {$this->table} ($fields) values ($placeholders)";
        db()->query($query, $this->attributes);

        return db()->getInsertId();
    }

    public function loadData(): void
    {
        $data = request()->getData();

        foreach ($this->loaded as $field) {
            if (!isset($data[$field])) {
                $this->attributes[$field] = '';
                continue;
            }

            $this->attributes[$field] = $data[$field];
        }
    }

    public function validate($data = [], $rules = []): bool
    {
        if (!$data) {
            $data = $this->attributes;
        }

        if (!$rules) {
            $rules = $this->rules;
        }

        $validator = new Validator($data);
        $validator->rules($rules);

        if (!$validator->validate()) {
            $this->errors = $validator->errors();
            return false;

        }

        return true;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}