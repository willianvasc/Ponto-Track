<?php

declare(strict_types=1);

include 'vendor/autoload.php';
include 'functions.php';

use Dotenv\Dotenv;

// Carrega as variáveis do .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$route = getRoute();

// Roteamento simples
if (isset($route)) {
    switch ($route) {
        case 'weather':
            // Pega IP do cliente
            $ip = getClientIp();

            // Carrega IPs autorizados
            $ip_file = __DIR__ . '/ips.json';
            $ips = [];
            if (file_exists($ip_file)) {
                $ips = json_decode(file_get_contents($ip_file), true) ?? [];
            }

            // Verifica se IP está autorizado
            if (!in_array($ip, $ips, true)) {
                json_response([
                    'ok' => false,
                    'error' => 'IP não autorizado. Cadastre seu IP primeiro no endpoint /ips.'
                ], 403);
            }

            // Se estiver autorizado, inclui weather.php
            include 'pages/weather.php';
            break;
        case 'subscribeIp':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                json_response(['ok' => false, 'error' => 'Método não permitido'], 405);
            } else if (!isset($_POST['token']) || $_POST['token'] !==  $_ENV['OAUTH_TOKEN']) {
                json_response(['ok' => false, 'error' => 'Não autorizado'], 401);
            }
            cadastrarIp();
            break;
        default:
            echo "Hi to weather API";
            break;
    }
}

