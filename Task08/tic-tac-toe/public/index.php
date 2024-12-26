<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

// Маршрут для главной страницы
$app->get('/', function ($request, $response) {
    $filePath = __DIR__ . '/index.html';
    if (file_exists($filePath)) {
        $response->getBody()->write(file_get_contents($filePath));
    } else {
        $response->getBody()->write('Файл index.html не найден.');
    }
    return $response->withHeader('Content-Type', 'text/html');
});

// Маршрут для получения списка игр
$app->get('/games', function ($request, $response) {
    // Подключение к базе данных
    $dbPath = __DIR__ . '/../db/database.db';
    $db = new PDO("sqlite:$dbPath");

    // Получение данных из базы
    $stmt = $db->query('SELECT * FROM games');
    $games = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Возврат JSON
    $response->getBody()->write(json_encode($games));
    return $response->withHeader('Content-Type', 'application/json');
});

// Маршрут для добавления новой игры
$app->post('/games', function ($request, $response) {
    $dbPath = __DIR__ . '/../db/database.db';
    $db = new PDO("sqlite:$dbPath");

    // Получение JSON-данных из запроса
    $data = json_decode($request->getBody()->getContents(), true);

    // Добавление игры в базу данных
    $stmt = $db->prepare('INSERT INTO games (player_name, game_date, result) VALUES (:player_name, :game_date, :result)');
    $stmt->execute([
        ':player_name' => $data['player_name'],
        ':game_date' => $data['game_date'],
        ':result' => $data['result'],
    ]);

    $response->getBody()->write(json_encode(['status' => 'success']));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
