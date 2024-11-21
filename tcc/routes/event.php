<?php
require_once __DIR__ . '/../controllers/eventController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    // Salvar os dados em um arquivo de log (event.txt)
    file_put_contents('event.txt', json_encode($input, JSON_PRETTY_PRINT) . "\n", FILE_APPEND);

    // Chamar a função do controller
    $response = handleEventRequest($input);

    file_put_contents('event2.txt', $response);
    // Definir o código de resposta HTTP
    // http_response_code($response['status']);
    // echo json_encode(['message' => $response['message']]);
}
