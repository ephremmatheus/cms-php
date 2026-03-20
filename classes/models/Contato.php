<?php
require_once __DIR__ . '/../Database.php';
class Contato
{
    private static $conn;

    private static function getConn()
    {
        if (!self::$conn) {
            self::$conn = Database::getConnection();
        }
        return self::$conn;
    }

    public static function save($data)
    {
        $conn = self::getConn();

        if (empty($data['codigo_mensagem'])) {
            $result = $conn->query("SELECT max(codigo_mensagem) as next from mensagens_contato");
            $row = $result->fetch();
            $data['codigo_mensagem'] = (int) $row['next'] + 1;

            $sql = "INSERT INTO mensagens_contato (codigo_mensagem, nome, email, telefone, mensagem) values(:codigo_mensagem, :nome, :email, :telefone, :mensagem)";
        } else {
            $sql = "UPDATE mensagens_contato 
                SET nome = :nome, email = :email, telefone = :telefone, mensagem = :mensagem 
                WHERE codigo_mensagem = :codigo_mensagem";
        }

        $stmt = $conn->prepare($sql);
        $success = $stmt->execute([
            ":codigo_mensagem" => $data['codigo_mensagem'],
            ":nome" => $data['nome'],
            ":email" => $data['email'],
            ":telefone" => $data['telefone'],
            ":mensagem" => $data['mensagem']
        ]);
        return $success;
    }

    public static function find($codigo_mensagem)
    {
        $conn = self::getConn();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM mensagens_contato WHERE codigo_mensagem = :codigo_mensagem";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':codigo_mensagem' => $codigo_mensagem
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function delete($codigo_mensagem)
    {
        $conn = self::getConn();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM mensagens_contato WHERE codigo_mensagem = :codigo_mensagem";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':codigo_mensagem' => $codigo_mensagem
        ]);

        return 'deletado';
    }

    public static function all()
    {
        $conn = self::getConn();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'SELECT * FROM mensagens_contato';

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>