<?php

class DashboardForm
{
    private $html;

    public function __construct()
    {
        // Trava de segurança no construtor da página restrita
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?class=LoginForm");
            exit;
        }
        $this->html = file_get_contents('../../html/dashboard.html');
    }

    public function sair($param)
    {
        session_unset();
        session_destroy();
        header("Location: index.php?class=LoginForm");
        exit;
    }

    public function show()
    {
        // Substitui o nome usando o dado salvo na sessão
        $this->html = str_replace('{NOME_USUARIO}', $_SESSION['usuario_nome'], $this->html);
        print $this->html;
    }
}