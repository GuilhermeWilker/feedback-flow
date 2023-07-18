<?php

/**
 * Método que realiza a conexão com banco de dados.
 *  MySQL.
 *
 * @return PDO
 */
function connect()
{
    return new PDO('mysql:host=127.0.0.1;dbname=feedback_flow', 'root', '', [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    ]);
}
