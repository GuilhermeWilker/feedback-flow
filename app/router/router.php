<?php

function getRoutes(): array
{
    return require 'web.php';
}

function findMatchingRoutesInArray(string $uri, array $routes): array
{
    if (array_key_exists($uri, $routes)) {
        return [$uri => $routes[$uri]];
    }

    return [];
}

function findMatchingRoutesWithRegex(string $uri, array $routes): array
{
    return array_filter(
        $routes,
        function ($value) use ($uri) {
            $regex = str_replace('/', '\/', ltrim($value, '/'));

            return preg_match("/^$regex$/", ltrim($uri, '/'));
        },
        ARRAY_FILTER_USE_KEY
    );
}

function extractParamsFromUri($uri, $matchedUri): array
{
    if (!empty($matchedUri)) {
        $matchedToGetParams = array_keys($matchedUri)[0];

        return array_diff(
            explode('/', ltrim($uri, '/')),
            explode('/', ltrim($matchedToGetParams, '/')),
        );
    }

    return [];
}

function formatParams($uri, $params)
{
    $uri = explode('/', ltrim($uri, '/'));

    $paramsData = [];
    foreach ($params as $index => $param) {
        $paramsData[$uri[$index - 1]] = $param;
    }

    return $paramsData;
}

function router()
{
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $routes = getRoutes();
    $params = [];

    $matchedUri = findMatchingRoutesInArray($uri, $routes);
    if (empty($matchedUri)) {
        $matchedUri = findMatchingRoutesWithRegex($uri, $routes);

        $params = extractParamsFromUri($uri, $matchedUri);
        $params = formatParams($uri, $params);
    }

    if (!empty($matchedUri)) {
        return loadController($matchedUri, $params);
    }

    throw new Exception('Algo deu errado');
}
