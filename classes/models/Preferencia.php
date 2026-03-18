<?php 

    require_once __DIR__ . '/../Database.php';
    class Preferencia {

        private static $conn;

        private static function getConn(){
            if(!self::$conn){
                self::$conn = Database::getConnection();
            }
            return self::$conn;
        }

        public static function save($data){
            $conn = self::getConn();

            if(empty($data['id'])){
                $result = $conn->query("SELECT max(id) as next from preferencias");
                $row = $result->fetch();
                $data['id'] = (int) $row['next'] + 1;

                //se id vazio então é para adicionar 
                $sql =  "INSERT INTO preferencias (id,
                    titulo_landing_page,
                    favicon,
                    logo_cabecalho,
                    link_facebook,
                    link_instagram,
                    titulo_secao_home,
                    subtitulo_secao_home,
                    imagem_secao_home,
                    titulo_caracteristicas_home,
                    titulo_secao_testemunho,
                    titulo_secao_loja_apps,
                    subtitulo_secao_loja_apps,
                    imagem_secao_loja_apps,
                    imagem_appstore	,
                    imagem_playstore,
                    telefone_contato,
                    logo_rodape,
                    mensagem_copyright,
                    url_rodape,
                    mensagem_powered) VALUES (:id,
                    :titulo_landing_page,
                    :favicon,
                    :logo_cabecalho,
                    :link_facebook,
                    :link_instagram,
                    :titulo_secao_home,
                    :subtitulo_secao_home,
                    :imagem_secao_home,
                    :titulo_caracteristicas_home,
                    :titulo_secao_testemunho,
                    :titulo_secao_loja_apps,
                    :subtitulo_secao_loja_apps,
                    :imagem_secao_loja_apps,
                    :imagem_appstore	,
                    :imagem_playstore,
                    :telefone_contato,
                    :logo_rodape,
                    :mensagem_copyright,
                    :url_rodape,
                    :mensagem_powered)";
            } else {

                //id não está vazio então é update
                $sql = "UPDATE preferencias SET
                titulo_landing_page = :titulo_landing_page,
                favicon = :favicon,
                logo_cabecalho = :logo_cabecalho,
                link_facebook = :link_facebook,
                link_instagram = :link_instagram,
                titulo_secao_home = :titulo_secao_home,
                subtitulo_secao_home = :subtitulo_secao_home,
                imagem_secao_home = :imagem_secao_home,
                titulo_caracteristicas_home = :titulo_caracteristicas_home,
                titulo_secao_testemunho = :titulo_secao_testemunho,
                titulo_secao_loja_apps = :titulo_secao_loja_apps,
                subtitulo_secao_loja_apps = :subtitulo_secao_loja_apps,
                imagem_secao_loja_apps = :imagem_secao_loja_apps,
                imagem_appstore = :imagem_appstore,
                imagem_playstore = :imagem_playstore,
                telefone_contato = :telefone_contato,
                logo_rodape = :logo_rodape,
                mensagem_copyright = :mensagem_copyright,
                url_rodape = :url_rodape,
                mensagem_powered = :mensagem_powered
                WHERE id = :id";
            }

            $stmt = $conn->prepare($sql);
            $success = $stmt->execute([
                ':id' => $data['id'],
                ':titulo_landing_page' => $data['titulo_landing_page'],
                ':favicon' => $data['favicon'],
                ':logo_cabecalho' => $data['logo_cabecalho'],
                ':link_facebook' => $data['link_facebook'],
                ':link_instagram' => $data['link_instagram'],
                ':titulo_secao_home' => $data['titulo_secao_home'],
                ':subtitulo_secao_home' => $data['subtitulo_secao_home'],
                ':imagem_secao_home' => $data['imagem_secao_home'],
                ':titulo_caracteristicas_home' => $data['titulo_caracteristicas_home'],
                ':titulo_secao_testemunho' => $data['titulo_secao_testemunho'],
                ':titulo_secao_loja_apps' => $data['titulo_secao_loja_apps'],
                ':subtitulo_secao_loja_apps' => $data['subtitulo_secao_loja_apps'],
                ':imagem_secao_loja_apps' => $data['imagem_secao_loja_apps'],
                ':imagem_appstore' => $data['imagem_appstore'],
                ':imagem_playstore' => $data['imagem_playstore'],
                ':telefone_contato' => $data['telefone_contato'],
                ':logo_rodape' => $data['logo_rodape'],
                ':mensagem_copyright' => $data['mensagem_copyright'],
                ':url_rodape' => $data['url_rodape'],
                ':mensagem_powered' => $data['mensagem_powered']
            ]);
            return $success;
        }

        public static function find($id){
            $conn = self::getConn();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM preferencias WHERE id = :id";

            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':id' => $id
            ]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        public static function delete($id){
            $conn = self::getConn();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM preferencias WHERE id = :id";

            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':id' => $id
            ]);

            return 'Preferencia deletada';
        }

        public static function all(){
            $conn = self::getConn();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = 'SELECT * FROM preferencias';

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    }
?>