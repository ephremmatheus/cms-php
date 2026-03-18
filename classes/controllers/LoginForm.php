<?php
require_once __DIR__ . '/../models/Usuario.php';

class LoginForm
{
    private $html;
    private $data;
    private $mensagem;

    public function __construct()
    {
        $this->html = file_get_contents(__DIR__ . '/../../html/login.html');
        $this->data = ['login' => ''];
        $this->mensagem = '';
    }

    public function logar($param)
    {
        $login = $param['login'];
        $senha = $param['senha'];

        $this->data['login'] = $login;

        $usuario = Usuario::findByLogin($login);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['codigo_usuario'];
            $_SESSION['usuario_login'] = $usuario['login'];

            header("Location: index.php?class=DashboardForm");
            exit;
        } else {
            $this->mensagem = "Login ou senha incorretos.";
        }
    }

    public function show()
    {
        $this->html = str_replace('{login}', $this->data['login'], $this->html);
        $this->html = str_replace('{mensagem}', $this->mensagem, $this->html);

        print $this->html;
    }
}