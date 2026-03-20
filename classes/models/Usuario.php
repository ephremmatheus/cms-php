<?php
require_once __DIR__ . '/../Database.php';

class Usuario
{
    public static function save($usuario)
    {
        $conn = Database::getConnection();

        if (isset($usuario['id'])) {
            $usuario['codigo_usuario'] = $usuario['id'];
        }


        if (!empty($usuario['senha'])) {
            $usuario['senha'] = password_hash($usuario['senha'], PASSWORD_DEFAULT);
        }

        if (empty($usuario['codigo_usuario'])) {
            $result = $conn->query("SELECT max(codigo_usuario) as next from usuarios");
            $row = $result->fetch();
            $usuario['codigo_usuario'] = (int) $row['next'] + 1;

            $sql = "INSERT INTO usuarios (codigo_usuario, login, senha) 
                VALUES (:codigo_usuario, :login, :senha)";

            $result = $conn->prepare($sql);
            $result->execute([
                ':codigo_usuario' => $usuario['codigo_usuario'],
                ':login' => $usuario['login'],
                ':senha' => $usuario['senha']
            ]);

            return $conn->lastInsertId();

        } else {

            if (!empty($usuario['senha'])) {

                $sql = "UPDATE usuarios 
                    SET login = :login, senha = :senha 
                    WHERE codigo_usuario = :id";

                $params = [
                    ':id' => $usuario['codigo_usuario'],
                    ':login' => $usuario['login'],
                    ':senha' => $usuario['senha']
                ];

            } else {

                $sql = "UPDATE usuarios 
                    SET login = :login 
                    WHERE codigo_usuario = :id";

                $params = [
                    ':id' => $usuario['codigo_usuario'],
                    ':login' => $usuario['login']
                ];
            }

            $result = $conn->prepare($sql);
            $result->execute($params);
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