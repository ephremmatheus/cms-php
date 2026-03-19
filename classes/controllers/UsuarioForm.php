<?php

require_once __DIR__ . '/../models/Testemunho.php';

class UsuarioForm
{
    private $html;
    private $data;

    public function __construct()
    {
        $this->html = file_get_contents(__DIR__ . '/../../html/usuario/usuarioForm.html');
        $this->data = [
            'id' => null,
            'login' => null,
            'senha' => null,
        ];
    }

    public function edit($param)
    {
        try {
            $id = (int) $param['id'];
            $usuario = Usuario::find($id);
            $this->data = $usuario;

        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function save($param)
    {
        try {
            Usuario::save($param);
            $this->data = $param;
            header("Location: index.php?class=DashboardForm&page=usuarioList");
            exit;
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }
    public function show()
    {
        $this->html = str_replace('{id}', $this->data['id'], $this->html);
        $this->html = str_replace('{login}', $this->data['login'], $this->html);
        $this->html = str_replace('{senha}', $this->data['senha'], $this->html);

        print $this->html;
    }
}