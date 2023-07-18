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
