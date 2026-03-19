<?php
require_once __DIR__ . '/../models/CaracteristicaHome.php';

class CaracteristicaForm {

    private $html;
    private $data;

   
    public function __construct() {
        $this->html = file_get_contents(__DIR__ . '/../../html/caracteristicas/caracteristicaForm.html');
        $this->data = [
            'codigo_caracteristica' => null,
            'titulo'                => null,
            'descricao'             => null,
        ];
    }

    public function edit($param) {
        try {
            $id = (int) $param['id'];
            $caracteristica = CaracteristicaHome::find($id);
            $this->data = $caracteristica;
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

   
    public function save($param) {
    try {
        if (!isset($param['titulo'], $param['descricao'])) {
            throw new Exception("Dados incompletos.");
        }

        $id = isset($param['codigo_caracteristica']) ? (int)$param['codigo_caracteristica'] : 0;
        $titulo = trim($param['titulo']);
        $descricao = trim($param['descricao']);

        if (empty($titulo)) {
            throw new Exception("O título é obrigatório.");
        }

        if (empty($descricao)) {
            throw new Exception("A descrição é obrigatória.");
        }

        if (strlen($titulo) > 100) {
            throw new Exception("Título muito longo.");
        }

        if (strlen($descricao) > 500) {
            throw new Exception("Descrição muito longa.");
        }

        CaracteristicaHome::save([
            'codigo_caracteristica' => $id,
            'titulo' => $titulo,
            'descricao' => $descricao
        ]);

        header("Location: index.php?class=DashboardForm&page=caracteristicaList");
        exit;

    } catch (Exception $e) {
        print $e->getMessage();
    }
}

   
    public function show() {
        $this->html = str_replace('{codigo_caracteristica}', $this->data['codigo_caracteristica'], $this->html);
        $this->html = str_replace('{titulo}',                $this->data['titulo'],                $this->html);
        $this->html = str_replace('{descricao}',             $this->data['descricao'],             $this->html);

        print $this->html;
    }
}