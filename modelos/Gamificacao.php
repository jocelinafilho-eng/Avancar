<?php

class Gamificacao {
    private $conexao;

    public function __construct($bd) {
        $this->conexao = $bd;
    }

    public function adicionarPontos($usuario_id, $pontos) {
        $query = "UPDATE usuario SET pontos = pontos + :pontos WHERE id = :usuario_id";

        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':pontos', $pontos, PDO::PARAM_INT);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $this->verificarNivel($usuario_id);
            return true;
        }
        return false;
    }

    public function verificarNivel($usuario_id) {
        // Lógica simples: a cada 1000 pontos, sobe de nível
        $query_select = "SELECT pontos, nivel FROM usuario WHERE id = :usuario_id";
        $stmt_select = $this->conexao->prepare($query_select);
        $stmt_select->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt_select->execute();
        $usuario = $stmt_select->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $novo_nivel = floor($usuario['pontos'] / 1000) + 1;
            if ($novo_nivel > $usuario['nivel']) {
                $query_update = "UPDATE usuario SET nivel = :novo_nivel WHERE id = :usuario_id";
                $stmt_update = $this->conexao->prepare($query_update);
                $stmt_update->bindParam(':novo_nivel', $novo_nivel, PDO::PARAM_INT);
                $stmt_update->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
                $stmt_update->execute();
                // TODO: Notificar o usuário sobre o novo nível
            }
        }
    }

    public function atribuirBadge($usuario_id, $badge_id) {
        // Verificar se o usuário já tem o badge
        $query_check = "SELECT id FROM usuario_badge WHERE usuario_id = :usuario_id AND badge_id = :badge_id";
        $stmt_check = $this->conexao->prepare($query_check);
        $stmt_check->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt_check->bindParam(':badge_id', $badge_id, PDO::PARAM_INT);
        $stmt_check->execute();

        if ($stmt_check->rowCount() == 0) {
            $query = "INSERT INTO usuario_badge (usuario_id, badge_id) VALUES (:usuario_id, :badge_id)";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(':badge_id', $badge_id, PDO::PARAM_INT);
            $stmt->execute();
            // TODO: Notificar o usuário sobre o novo badge
        }
    }
}
