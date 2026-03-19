<?php 
require_once __DIR__ .  '/../models/Contato.php';

    class ContatoForm{
        private $html;
        private $data;

        public function __construct(){
            $this->html = file_get_contents(__DIR__ . '/../../html/contato/form.html');
            $this->data = [
                'codigo_mensagem' => null,
                'nome' => null,
                'email' => null,
                'telefone' => null,
                'mensagem' => null
            ];
        }

        public function edit($param){
            try{
                $codigo_mensagem = (int) $param['codigo_mensagem'];
                $contato = Contato::find($codigo_mensagem);
                $this->data = $contato ?? $this->data;
            } catch(Exception $e) {
                print $e->getMessage();
            }
        }

        public function save($param){
            try{
                Contato::save($param);
                $this->data = $param;
                header("Location: index.php?class=ContatoList&success=1");
                exit;
            } catch (Exception $e){
                print $e->getMessage();
            }
        }

        public function show(){
            $this->html = str_replace('{codigo_mensagem}', $this->data['codigo_mensagem'] ?? '', $this->html);
            $this->html = str_replace('{nome}', $this->data['nome'] ?? '', $this->html);
            $this->html = str_replace('{email}', $this->data['email'] ?? '', $this->html);
            $this->html = str_replace('{telefone}', $this->data['telefone'] ?? '', $this->html);
            $this->html = str_replace('{mensagem}', $this->data['mensagem'] ?? '', $this->html);

            print $this->html;
}
    }
?>