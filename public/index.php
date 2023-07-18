<?php

require './bootstrap.php';

try {
    $data = router();

    if (!isset($data['data'])) {
        throw new Exception('Não foi encontrado o indice $data..');
    }

    if (!isset($data['view'])) {
        throw new Exception('Não foi encontrado o indice view..');
    }

    if (!file_exists(VIEWS.$data['view'])) {
        throw new Exception("O arquivo de template {$data['view']} não existe..");
    }

    extract($data['data']);

    $view = $data['view'];

    require VIEWS.'master.php';
} catch (Exception $e) {
    var_dump($e->getMessage());
}
