<?php
require_once 'classes/Usuario.php';

class LoginForm
{
    private $html;
    private $data;
    private $mensagem;

    public function __construct()
    {
        $this->html = file_get_contents('html/login.html');
        $this->data = ['email' => ''];
        $this->mensagem = '';
    }

    public function logar($param)
    {
        $email = $param['email'];
        $senha = $param['senha'];

        $this->data['email'] = $email; // Mantém o email preenchido caso erre

        $usuario = Usuario::findByEmail($email);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Sucesso! Registra na sessão e redireciona
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            header("Location: index.php?class=DashboardForm");
            exit;
        } else {
            $this->mensagem = "E-mail ou senha incorretos.";
        }
    }

    public function show()
    {
        $this->html = str_replace('{email}', $this->data['email'], $this->html);
        $this->html = str_replace('{mensagem}', $this->mensagem, $this->html);
        print $this->html;
    }
}