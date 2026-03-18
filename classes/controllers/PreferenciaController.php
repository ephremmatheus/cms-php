<?php
require_once __DIR__ .  '/../models/Preferencia.php';

    class PreferenciaController{
        private $html;
        private $model;

        public function __construct(){
            $this->html = file_get_contents(__DIR__ . '/../../html/preferencias/layout.html');
            $this->model = new Preferencia();
        }

        public function index(){
            $preferencias = $this->model->all();
            include __DIR__ . '/../../html/preferencias/index.html';
        }

        public function form($request){
            $id = $request['id'] ?? null;

            $data = $id ? $this->model->find($id) : [];

            include __DIR__ . '/../../html/preferencias/form.html';
        }

        public function save($request, $id=null){
            if($id){ 
                $request['id'] = $id; //indica que é update
            }

            if($this->model->save($request)){
                header("Location: index.php?class=PreferenciaController&method=index");
                echo "salvo com sucesso";
                exit;
            } else {
                echo "Erro ao salvar preferencia";
            }
        }

        
        public function delete($request){
            $id = $request['id'] ?? null;

            if($this->model->delete($id)){
                header("Location: index.php?class=PreferenciaController&method=index");
                exit;
            } else {
                echo "Erro ao deletar preferencia";
    }
}

        public function show(){
            echo $this->html;
        }


    }

    /*
    index:
    http://localhost/CMS-PHP/admin/index.php?class=PreferenciaController&method=index
    save:
    http://localhost/CMS-PHP/admin/index.php?class=PreferenciaController&method=form
    edit:
    http://localhost/CMS-PHP/admin/index.php?class=PreferenciaController&method=form&id=2 
    delete:
    http://localhost/CMS-PHP/admin/index.php?class=PreferenciaController&method=delete&id=2
    */
?>

