<?php
require_once __DIR__ . '/../database/connect.php';

function createSession($input, $conn)
{
    $sql = "INSERT INTO session (player_id, start, mapName, active) VALUES (?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('ssss', $input['playerID'], $input['sessionDate'], $input['mapName'], $input['active']);
        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(['message' => 'Sessão criada com sucesso!']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erro ao salvar a sessão no banco de dados.']);
        }
        $stmt->close();
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Erro ao preparar a query SQL.']);
    }
}

function updateSession($input, $conn)
{
    $sql = "UPDATE session SET end = ? WHERE player_id = ? AND active = 1";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('ss', $input['sessionDate'], $input['playerID']);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                http_response_code(200);
                echo json_encode(['message' => 'Sessão atualizada com sucesso!']);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Sessão não encontrada para o jogador.']);
            }
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erro ao atualizar a sessão no banco de dados.']);
        }
        $stmt->close();
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Erro ao preparar a query SQL.']);
    }
}
