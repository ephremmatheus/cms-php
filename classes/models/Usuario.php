<?php
require_once __DIR__ . '/../Database.php';

class Usuario
{
    public static function save($usuario)
    {
        $conn = Database::getConnection();

        $senha_hash = password_hash($usuario['senha'], PASSWORD_DEFAULT);

        if (empty($usuario['codigo_usuario'])) {
            $sql = "INSERT INTO usuarios (login, senha) VALUES (:login, :senha)";
            $result = $conn->prepare($sql);
            $result->execute([
                ':login' => $usuario['login'],
                ':senha' => $senha_hash
            ]);
        } else {
            $sql = "UPDATE usuarios SET login = :login WHERE codigo_usuario = :id";
            $result = $conn->prepare($sql);
            $result->execute([
                ':id' => $usuario['codigo_usuario'],
                ':login' => $usuario['login']
            ]);
        }
    }

    public static function findByLogin($login)
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM usuarios WHERE login = :login";
        $result = $conn->prepare($sql);
        $result->execute([':login' => $login]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM usuarios WHERE codigo_usuario = :id";
        $result = $conn->prepare($sql);
        $result->execute([':id' => $id]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public static function all()
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM usuarios";
        $result = $conn->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function delete($id)
    {
        $conn = Database::getConnection();
        $sql = "DELETE FROM usuarios WHERE codigo_usuario = :id";
        $result = $conn->prepare($sql);
        $result->execute([':id' => $id]);
    }
}