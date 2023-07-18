<?php

function all($table, $fields = '*')
{
    try {
        $connect = connect();

        $query = $connect->query("select {$fields} from {$table} ");

        return $query->fetchAll();
    } catch (PDOException $e) {
        var_dump($e->getMessage());

        return [];
    }
}

function findBy(string $table, string $field, string $value, $fields = '*')
{
    try {
        $connect = connect();
        $prepare = $connect->prepare("
        select {$fields} from {$table} where {$field} = :{$field}");

        $prepare->execute([
            $field => $value,
            ]);

        return $prepare->fetch();
    } catch (PDOException $e) {
        $e->getMessage();
    }
}
