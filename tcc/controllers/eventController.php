<?php
require_once __DIR__ . '/../database/connect.php';

function createEvent($eventDate, $eventName, $sessionID)
{
    global $conn;

    $sql = "INSERT INTO events (sessionID, start, eventName) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('iss', $sessionID, $eventDate, $eventName);
        if ($stmt->execute()) {
            return ['status' => 201, 'message' => 'Evento de início salvo com sucesso!'];
        } else {
            return ['status' => 500, 'message' => 'Erro ao salvar o evento no banco de dados.'];
        }
        $stmt->close();
    }
    return ['status' => 500, 'message' => 'Erro ao preparar a query SQL para o evento de início.'];
}

function updateEventEnd($eventDate, $sessionID)
{
    global $conn;

    $sql = "UPDATE events SET end = ? WHERE sessionID = ? AND end IS NULL";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('si', $eventDate, $sessionID);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                return ['status' => 200, 'message' => 'Evento de fim atualizado com sucesso!'];
            } else {
                return ['status' => 404, 'message' => 'Sessão não encontrada ou evento de fim já registrado.'];
            }
        } else {
            return ['status' => 500, 'message' => 'Erro ao atualizar o evento no banco de dados.'];
        }
        $stmt->close();
    }
    return ['status' => 500, 'message' => 'Erro ao preparar a query SQL para o evento de fim.'];
}

function handleEventRequest($input)
{
    // file_put_contents('input.txt', json_encode($input));

    $eventDate = $input['eventDate'];
    $eventName = $input['eventName'];
    $eventPhase = $input['eventPhase'];

    // file_put_contents('input2.txt', $eventPhase);

    if ($eventPhase === 'start') {
        return createEvent($eventDate, $eventName, 3);
    } elseif ($eventPhase === 'end') {
        return updateEventEnd($eventDate, 3);
    } else {
        return ['status' => 400, 'message' => 'Fase do evento inválida.'];
    }
}
