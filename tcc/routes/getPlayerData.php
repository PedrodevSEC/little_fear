<?php
require_once __DIR__ . '/../controllers/playerController.php';

if (isset($_GET['playerID'])) {
    $playerID = $_GET['playerID'];

    $playerController = new PlayerController();

    $playerController->getPlayerData($playerID);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'playerID é obrigatório']);
}
