<?php
function json_response(array $data, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function getRoute(): ?string
{
    $url = $_GET['url'] ?? '';
    $url = rtrim($url, '/');
    $url = explode('/', $url);
    return $url[0] ?? null;
}

// ===========================
// Endpoint para cadastro de IPs
// ===========================
function cadastrarIp(): void
{
    $ip_file = __DIR__ . '/ips.json';

    // Carrega IPs existentes
    $ips = [];
    if (file_exists($ip_file)) {
        $content = file_get_contents($ip_file);
        $ips = json_decode($content, true) ?? [];
    }

    // Pega o IP do cliente automaticamente
    $ip = getClientIp();
    if (!$ip) {
        json_response(['ok' => false, 'error' => 'Não foi possível detectar o IP'], 500);
    }

    // Valida se o IP já está cadastrado
    if (ipExists($ip, $ips)) {
        json_response(['ok' => false, 'error' => 'IP já cadastrado'], 409);
    }

    // Adiciona e salva
    $ips[] = $ip;
    file_put_contents($ip_file, json_encode($ips, JSON_PRETTY_PRINT));

    json_response(['ok' => true, 'message' => 'IP cadastrado com sucesso', 'ip' => $ip]);
}

// Função para obter o IP do cliente
function getClientIp(): ?string
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // Pode conter múltiplos IPs, usamos o primeiro
        return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    }
    if (!empty($_SERVER['REMOTE_ADDR'])) {
        return $_SERVER['REMOTE_ADDR'];
    }
    return null;
}

// Função para validar IP
function ipExists(string $ip, array $ips): bool
{
    return in_array($ip, $ips, true);
}
