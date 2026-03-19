<?php

class DashboardForm
{
    private $html;

    public function __construct()
    {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?class=LoginForm");
            exit;
        }

        $this->html = file_get_contents(__DIR__ . '/../../html/dashboard.html');
    }

    public function show($param = [])
    {
        $login = $_SESSION['usuario_login'];

        // 🔐 menu usuarios
        if ($_SESSION['usuario_id'] == 1) {
            $menuUsuarios = '
                <li class="list-group-item">
                    <a href="index.php?class=DashboardForm&page=usuarioList">Usuários</a>
                </li>
            ';
        } else {
            $menuUsuarios = '';
        }


        $conteudo = '';

        if (isset($param['page'])) {
            $pagina = $param['page'];

            if ($pagina == 'testemunhoList') {
                $controller = new TestemunhoList();
                ob_start();
                $controller->show();
                $conteudo = ob_get_clean();
            } else if ($pagina == 'preferenciaList') {
                $controller = new PreferenciaList();
                ob_start();
                $controller->show();
                $conteudo = ob_get_clean();
            } else if ($pagina == 'usuarioList') {
                $controller = new UsuarioList();
                ob_start();
                $controller->show();
                $conteudo = ob_get_clean();
            }
            else {
                $conteudo = "<p>Página não encontrada</p>";
            }
        } else {
            $conteudo = "<h3>Bem-vindo ao Dashboard</h3>";
        }

        // 🔄 replace
        $this->html = str_replace('{login}', $login, $this->html);
        $this->html = str_replace('{menu_usuarios}', $menuUsuarios, $this->html);
        $this->html = str_replace('{conteudo}', $conteudo, $this->html);

        print $this->html;
    }

    public function sair()
    {
        session_unset();
        session_destroy();

        header("Location: index.php?class=LoginForm");
        exit;
    }
}