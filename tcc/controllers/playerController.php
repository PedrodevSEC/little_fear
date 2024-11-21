<?php
require_once __DIR__ . '/../database/connect.php';

class PlayerController
{
    public function getPlayerData($playerID)
    {
        global $conn;

        $sql = "SELECT ID, name, age, sex FROM player WHERE ID = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('i', $playerID);

            if ($stmt->execute()) {
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $playerData = $result->fetch_assoc();

                    echo json_encode($playerData);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Jogador não encontrado']);
                }
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Erro ao buscar dados do jogador']);
            }

            $stmt->close();
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erro ao preparar a consulta SQL']);
        }

        $conn->close();
    }
}
