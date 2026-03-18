<?php 
require_once __DIR__ .  '/../models/Preferencia.php';

    class PreferenciaForm {
        private $html;
        private $data;

        public function __construct(){
            $this->html = file_get_contents(__DIR__ . '/../../html/preferencias/form.html');
            $this->data = [
                'id' => null,
                'titulo_landing_page' => null,
                'favicon' => null,
                'logo_cabecalho' => null,
                'link_facebook' => null,
                'link_instagram' => null,
                'titulo_secao_home' => null,
                'subtitulo_secao_home' => null,
                'imagem_secao_home' => null,
                'titulo_caracteristicas_home' => null,
                'titulo_secao_testemunho' => null,
                'titulo_secao_loja_apps' => null,
                'subtitulo_secao_loja_apps' => null,
                'imagem_secao_loja_apps' => null,
                'imagem_appstore' => null,
                'imagem_playstore' => null,
                'telefone_contato' => null,
                'logo_rodape' => null,
                'mensagem_copyright' => null,
                'url_rodape' => null,
                'mensagem_powered' => null,
            ];
        }


        public function edit($param){
            try{
                $id = (int) $param['id'];
                $preferencia = Preferencia::find($id);
                $this->data = $preferencia ?? $this->data;
            } catch(Exception $e) {
                print $e->getMessage();
            }
        }

        public function save($param){
            try{
                Preferencia::save($param);
                $this->data = $param;
                print "Preferencia salva com sucesso";
            } catch (Exception $e){
                print $e->getMessage();
            }
        }


        public function show(){
            $this->html = str_replace('{id}', $this->data['id'], $this->html);
            $this->html = str_replace('{titulo_landing_page}', $this->data['titulo_landing_page'], $this->html);
            $this->html = str_replace('{favicon}', $this->data['favicon'], $this->html);
            $this->html = str_replace('{logo_cabecalho}', $this->data['logo_cabecalho'], $this->html);
            $this->html = str_replace('{link_facebook}', $this->data['link_facebook'], $this->html);
            $this->html = str_replace('{link_instagram}', $this->data['link_instagram'], $this->html);

            $this->html = str_replace('{titulo_secao_home}', $this->data['titulo_secao_home'], $this->html);
            $this->html = str_replace('{subtitulo_secao_home}', $this->data['subtitulo_secao_home'], $this->html);
            $this->html = str_replace('{imagem_secao_home}', $this->data['imagem_secao_home'], $this->html);

            $this->html = str_replace('{titulo_caracteristicas_home}', $this->data['titulo_caracteristicas_home'], $this->html);

            $this->html = str_replace('{titulo_secao_testemunho}', $this->data['titulo_secao_testemunho'], $this->html);

            $this->html = str_replace('{titulo_secao_loja_apps}', $this->data['titulo_secao_loja_apps'], $this->html);
            $this->html = str_replace('{subtitulo_secao_loja_apps}', $this->data['subtitulo_secao_loja_apps'], $this->html);
            $this->html = str_replace('{imagem_secao_loja_apps}', $this->data['imagem_secao_loja_apps'], $this->html);
            $this->html = str_replace('{imagem_appstore}', $this->data['imagem_appstore'], $this->html);
            $this->html = str_replace('{imagem_playstore}', $this->data['imagem_playstore'], $this->html);

            $this->html = str_replace('{telefone_contato}', $this->data['telefone_contato'], $this->html);

            $this->html = str_replace('{logo_rodape}', $this->data['logo_rodape'], $this->html);
            $this->html = str_replace('{mensagem_copyright}', $this->data['mensagem_copyright'], $this->html);
            $this->html = str_replace('{url_rodape}', $this->data['url_rodape'], $this->html);
            $this->html = str_replace('{mensagem_powered}', $this->data['mensagem_powered'], $this->html);

            print $this->html;
        }
    }
?>