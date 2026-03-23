<?php
require_once __DIR__ . '/../Database.php';

class CaracteristicaApp {

    private static $conn;

    // abre a conexao com o banco
    private static function getConn() {
        if (!self::$conn) {
            self::$conn = Database::getConnection();
        }
        return self::$conn;
    }

    // salva, se não tiver código é insert, se tiver é update
    public static function save($data) {
        $conn = self::getConn();

        if (empty($data['codigo_caracteristica_app'])) {
            // pega o maior código existente e soma 1
            $result = $conn->query("SELECT max(codigo_caracteristica_app) as next from caracteristicas_aplicativo");
            $row = $result->fetch();
            $data['codigo_caracteristica_app'] = (int) $row['next'] + 1;

            $sql = "INSERT INTO caracteristicas_aplicativo (codigo_caracteristica_app, titulo, descricao)
                    VALUES (:codigo_caracteristica_app, :titulo, :descricao)";
        } else {
            // código veio preenchido, então atualiza o registro existente
            $sql = "UPDATE caracteristicas_aplicativo SET
                    titulo = :titulo,
                    descricao = :descricao
                    WHERE codigo_caracteristica_app = :codigo_caracteristica_app";
        }

        $stmt = $conn->prepare($sql);
        $success = $stmt->execute([
            ':codigo_caracteristica_app' => $data['codigo_caracteristica_app'],
            ':titulo'                    => $data['titulo'],
            ':descricao'                 => $data['descricao'],
        ]);

        return $success;
    }

    // busca uma característica específica pelo id
    public static function find($id) {
        $conn = self::getConn();
        $sql = "SELECT * FROM caracteristicas_aplicativo WHERE codigo_caracteristica_app = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // apaga uma característica pelo id
    public static function delete($id) {
        $conn = self::getConn();
        $sql = "DELETE FROM caracteristicas_aplicativo WHERE codigo_caracteristica_app = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    // retorna todas as características cadastradas
    public static function all() {
        $conn = self::getConn();
        $sql = "SELECT * FROM caracteristicas_aplicativo";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}