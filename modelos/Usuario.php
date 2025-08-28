<?php

class Usuario {
    private $conexao;
    private $tabela = 'usuario';

    public $id;
    public $nome;
    public $email;
    public $palavra_passe;
    public $data_registo;

    public function __construct($bd) {
        $this->conexao = $bd;
    }

    public function criar() {
        $query = "INSERT INTO " . $this->tabela . " SET nome = :nome, email = :email, palavra_passe = :palavra_passe";

        $stmt = $this->conexao->prepare($query);

        // Sanitização
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->email = htmlspecialchars(strip_tags($this->email));

        // A palavra-passe será hasheada no controlador
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':palavra_passe', $this->palavra_passe);

        if ($stmt->execute()) {
            return true;
        }

        printf("Erro: %s.\n", $stmt->error);

        return false;
    }

    public function encontrarPorEmail($email) {
        $query = "SELECT * FROM " . $this->tabela . " WHERE email = :email LIMIT 1";

        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function encontrarPorId($id) {
        $query = "SELECT * FROM " . $this->tabela . " WHERE id = :id LIMIT 1";

        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function marcarOnboardingConcluido($usuario_id) {
        $query = "UPDATE " . $this->tabela . " SET onboarding_concluido = 1 WHERE id = :id";

        $stmt = $this->conexao->prepare($query);

        $usuario_id = htmlspecialchars(strip_tags($usuario_id));

        $stmt->bindParam(':id', $usuario_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
