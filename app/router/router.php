<?php

/**
 * Retorna o array de rotas.
 *
 * @return array 'web.php'
 */
function getRoutes(): array
{
    return require 'web.php';
}

/**
 * O método deve retornar uma rota exata ou seja, sem parâmetros dinâmicos.
 *
 * @param string $uri    ->
 * @param array  $routes ->
 *
 * @return array ->  vazio ou com as rotas encontradas.
 */
function findMatchingRoutesInArray(string $uri, array $routes): array
{
    if (array_key_exists($uri, $routes)) {
        return [$uri => $routes[$uri]];
    }

    return [];
}

/**
 * O método deve retornar rotas dinâmicas ou seja, com parâmetros passados na url.
 * paramêtros esses que são validados através de regex.
 *
 * @param string $uri    ->
 * @param array  $routes -> @function routes()
 *
 * @return array -> rotas dinamicas encontradas
 */
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

/**
 * Método que extrai os parâmetros vindo da url.
 *
 * @param mixed $uri
 * @param mixed $matchedUri
 */
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

/**
 * Método para direcionar as solicitações HTTP para os controladores apropriados,
 * com base nas rotas definidas no aplicativo.
 *
 * @return mixed -> retorna o resultado da execução do controlador correspondente.
 *
 * @throws \Exception
 */
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
