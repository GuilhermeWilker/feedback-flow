<?php

function loadController($matchedUri, $params)
{
    [$controller, $method] = explode('@', array_values($matchedUri)[0]);

    $controllerWithNamespace = CONTROLLER_PATH.$controller;

    if (!class_exists($controllerWithNamespace)) {
        throw new Exception("O controller {$controller} não foi encontrado..");
    }

    $controllerInstance = new $controllerWithNamespace();

    if (!method_exists($controllerInstance, $method)) {
        throw new Exception("O método {$method} do controller {$controller} não foi encontrado..");
    }

    return $controllerInstance->$method($params);
}
