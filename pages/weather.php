<?php
$cidade = isset($_GET['cidade']) ? $_GET['cidade'] : '';
$unidade = isset($_GET['unidade']) ? strtolower($_GET['unidade']) : 'c';

if (!isset($_GET['cidade'])) {
    json_response(['ok' => false, 'error' => 'Parâmetro "cidade" é obrigatório. Ex: ?cidade=São Paulo'], 400);
}

// ====================
// Busca a latitude e longitude do projeto
// ====================
$urlGeo = "http://api.openweathermap.org/geo/1.0/direct?q=" . urlencode($cidade) . "&limit=1&appid=" . $_ENV['OWM_API_KEY'];

$ch = curl_init($urlGeo);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10,
]);
$responseGeo = curl_exec($ch);
$errnoGeo    = curl_errno($ch);
$errorGeo    = curl_error($ch);
curl_close($ch);

if ($errnoGeo !== 0) {
    json_response(['ok' => false, 'error' => $errorGeo], 502);
}

$dataGeo = json_decode($responseGeo, true);

if (!is_array($dataGeo) || count($dataGeo) === 0) {
    json_response(['ok' => false, 'error' => 'Cidade não encontrada.'], 404);
}

$resultGeo = $dataGeo[0];
$lat = $resultGeo['lat'] ?? null;
$lon = $resultGeo['lon'] ?? null;

// =====================
// 2) Busca a Temperatura
// =====================
$units = $unidade === 'f' ? 'imperial' : 'metric';
$symbol = $unidade === 'f' ? 'F' : 'C';

$urlWeather = "https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&units={$units}&appid=" . $_ENV['OWM_API_KEY'] . "&lang=pt_br";

$ch = curl_init($urlWeather);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10,
]);
$responseWeather = curl_exec($ch);
$errnoW    = curl_errno($ch);
$errorW    = curl_error($ch);
curl_close($ch);

if ($errnoW !== 0) {
    json_response(['ok' => false, 'error' => $errorW], 502);
}

$dataWeather = json_decode($responseWeather, true);

if (!isset($dataWeather['main']['temp'])) {
    json_response(['ok' => false, 'error' => 'Não foi possível obter temperatura.'], 500);
}

// =====================
// 3) Resposta Final
// =====================
json_response([
    'ok' => true,
    'cidade' => $resultGeo['name'] ?? $cidade,
    'estado' => $resultGeo['state'] ?? null,
    'pais'   => $resultGeo['country'] ?? null,
    'lat'    => $lat,
    'lon'    => $lon,
    'temperatura' => $dataWeather['main']['temp'],
    'feels_like'  => $dataWeather['main']['feels_like'] ?? null,
    'umidade'     => $dataWeather['main']['humidity'] ?? null,
    'descricao'   => $dataWeather['weather'][0]['description'] ?? null,
    'unidade'     => $symbol
]);
