<?php 

    require_once __DIR__ . '/../Database.php';
    class Testemunho {

        private static $conn;

        private static function getConn(){
            if(!self::$conn){
                self::$conn = Database::getConnection();
            }
            return self::$conn;
        }

        public static function save($data){
            $conn = self::getConn();

            if(empty($data['codigo_testemunho'])){
                $result = $conn->query("SELECT max(codigo_testemunho) as next from testemunhos");
                $row = $result->fetch();
                $data['codigo_testemunho'] = (int) $row['next'] + 1;

                $sql =  "INSERT INTO testemunhos (codigo_testemunho, nome, funcao, titulo, descricao, foto, imagem_fundo) VALUES (:codigo_testemunho, :nome, :funcao, :titulo, :descricao, :foto, :imagem_fundo)";
            } else {

                $sql = "UPDATE testemunhos SET
                nome = :nome,
                funcao = :funcao,
                titulo = :titulo,
                descricao = :descricao,
                foto = :foto,
                imagem_fundo = :imagem_fundo
                WHERE codigo_testemunho = :codigo_testemunho";
            }

            $stmt = $conn->prepare($sql);
            $success = $stmt->execute([
                ':codigo_testemunho' => $data['codigo_testemunho'],
                ':nome' => $data['nome'],
                ':titulo' => $data['titulo'],
                ':funcao' => $data['funcao'],
                ':descricao' => $data['descricao'],
                ':foto' => $data['foto'],
                ':imagem_fundo' => $data['imagem_fundo']
            ]);
            return $success;
        }

        public static function find($codigo_testemunho){
            $conn = self::getConn();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM testemunhos WHERE codigo_testemunho = :codigo_testemunho";

            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':codigo_testemunho' => $codigo_testemunho
            ]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        public static function delete($codigo_testemunho){
            $conn = self::getConn();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM testemunhos WHERE codigo_testemunho = :codigo_testemunho";

            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':codigo_testemunho' => $codigo_testemunho
            ]);

            return 'Preferencia deletada';
        }

        public static function all(){
            $conn = self::getConn();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = 'SELECT * FROM testemunhos';

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    }
?>