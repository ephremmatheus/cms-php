<?php

require_once __DIR__ . '/../models/Testemunho.php';

class UsuarioList
{
    private $html;

    public function __construct()
    {
        $this->html = file_get_contents(__DIR__ . '/../../html/usuario/usuarioList.html');
    }

    public function delete($param)
    {
        try {
            $id = (int) $param['id'];
            Usuario::delete($id);
            header("Location: index.php?class=DashboardForm&page=usuarioList");
            exit;
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function load()
    {
        try {
            $usuarios = Usuario::all();
            $items = '';

            if (empty($usuarios)) {
                $items = '
                <tr>
                    <td colspan="8" style="text-align:center;">
                        Nenhum usuário cadastrado.
                    </td>
                </tr>
            ';
            } else {
                foreach ($usuarios as $usuario) {
                    $item = file_get_contents(__DIR__ . '/../../html/usuario/usuarioItem.html');

                    $item = str_replace('{id}', $usuario['codigo_usuario'], $item);
                    $item = str_replace('{login}', $usuario['login'], $item);
                    $item = str_replace('{senha}', $usuario['senha'], $item);

                    $items .= $item;
                }
            }

            $this->html = str_replace('{items}', $items, $this->html);

        } catch (Exception $e) {
            print $e->getMessage();
        }
    }
    public function show()
    {
        
        $this->load();
        print $this->html;
    }
}