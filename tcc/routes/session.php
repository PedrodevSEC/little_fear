<?php
require_once __DIR__ . '/../controllers/sessionController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    $requiredFields = ['playerID', 'sessionDate', 'mapName', 'active', 'phase'];
    foreach ($requiredFields as $field) {
        if (!isset($input[$field])) {
            http_response_code(400);
            echo json_encode(['error' => "O campo '$field' é obrigatório."]);
            exit;
        }
    }

    $phase = $input['phase'];
    if ($phase === 'start') {
        createSession($input, $conn);
    } elseif ($phase === 'end') {
        updateSession($input, $conn);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Fase inválida.']);
    }
}
