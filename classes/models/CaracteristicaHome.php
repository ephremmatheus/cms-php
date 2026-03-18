<?php

// precisamos do Database.php pra conseguir conectar no banco
require_once __DIR__ . '/../Database.php';

class CaracteristicaHome {

    private static $conn;

    // função interna que abre a conexão com o banco (usada pelas outras funções abaixo)
    private static function getConn() {
        if (!self::$conn) {
            self::$conn = Database::getConnection();
        }
        return self::$conn;
    }

    // salva uma característica — se não tiver código é INSERT, se tiver é UPDATE
    public static function save($data) {
        $conn = self::getConn();

        if (empty($data['codigo_caracteristica'])) {
            // pega o maior código existente e soma 1 pra gerar o próximo
            $result = $conn->query("SELECT max(codigo_caracteristica) as next from caracteristicas_home");
            $row = $result->fetch();
            $data['codigo_caracteristica'] = (int) $row['next'] + 1;

            $sql = "INSERT INTO caracteristicas_home (codigo_caracteristica, titulo, descricao)
                    VALUES (:codigo_caracteristica, :titulo, :descricao)";
        } else {
            // código veio preenchido, então só atualiza o registro existente
            $sql = "UPDATE caracteristicas_home SET
                    titulo = :titulo,
                    descricao = :descricao
                    WHERE codigo_caracteristica = :codigo_caracteristica";
        }

        $stmt = $conn->prepare($sql);
        $success = $stmt->execute([
            ':codigo_caracteristica' => $data['codigo_caracteristica'],
            ':titulo'                => $data['titulo'],
            ':descricao'             => $data['descricao'],
        ]);

        return $success;
    }

    // busca uma característica específica pelo id
    public static function find($id) {
        $conn = self::getConn();
        $sql = "SELECT * FROM caracteristicas_home WHERE codigo_caracteristica = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // apaga uma característica pelo id
    public static function delete($id) {
        $conn = self::getConn();
        $sql = "DELETE FROM caracteristicas_home WHERE codigo_caracteristica = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    // retorna todas as características cadastradas
    public static function all() {
        $conn = self::getConn();
        $sql = "SELECT * FROM caracteristicas_home";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}