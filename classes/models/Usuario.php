<?php
require_once __DIR__ . '/../Database.php';
class Usuario
{
    private static $conn;

    public static function save($usuario)
    {
        $conn = Database::getConnection();

        // Criptografa a senha antes de salvar
        $senha_hash = password_hash($usuario['senha'], PASSWORD_DEFAULT);

        if (empty($usuario['id'])) {
            $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
            $result = $conn->prepare($sql);
            $result->execute([
                ':nome' => $usuario['nome'],
                ':email' => $usuario['email'],
                ':senha' => $senha_hash
            ]);
        } else {
            // Lógica de update caso precise no futuro
            $sql = "UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id";
            $result = $conn->prepare($sql);
            $result->execute([
                ':id' => $usuario['id'],
                ':nome' => $usuario['nome'],
                ':email' => $usuario['email']
            ]);
        }
    }

    public static function findByEmail($email)
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $result = $conn->prepare($sql);
        $result->execute([':email' => $email]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }
}
?>