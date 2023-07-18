<?php

namespace app\controllers;

class Home
{
    public function index($params)
    {
        return [
            'view' => 'project_info.php',
            'data' => ['title' => 'Home'],
            ];
    }
}
