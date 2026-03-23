<?php
require_once __DIR__ . '/../models/CaracteristicaApp.php';

class CaracteristicaAppForm {

    private $html;
    private $data;

    // carrega o html do formulário e prepara os campos vazios pra um novo cadastro
    public function __construct() {
        $this->html = file_get_contents(__DIR__ . '/../../html/caracteristicasApp/caracteristicaAppForm.html');
        $this->data = [
            'codigo_caracteristica_app' => null,
            'titulo'                    => null,
            'descricao'                 => null,
        ];
    }

    // quando clica em editar, busca os dados do banco e preenche o $this->data
    public function edit($param) {
        try {
            $id = (int) $param['id'];
            $caracteristica = CaracteristicaApp::find($id);
            $this->data = $caracteristica;
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    // recebe os dados do formulário, manda salvar e volta pra lista
    public function save($param) {
        try {
            CaracteristicaApp::save($param);
            header("Location: index.php?class=DashboardForm&page=caracteristicaAppList");
            exit;
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    // substitui os placeholders do html pelos dados e exibe na tela
    public function show() {
        $this->html = str_replace('{codigo_caracteristica_app}', $this->data['codigo_caracteristica_app'], $this->html);
        $this->html = str_replace('{titulo}',                    $this->data['titulo'],                    $this->html);
        $this->html = str_replace('{descricao}',                 $this->data['descricao'],                 $this->html);

        print $this->html;
    }
}