<?php
require_once __DIR__ . '/../models/Usuario.php';

class RegistroForm
{
    private $html;
    private $data;
    private $mensagem;

    public function __construct()
    {
        $this->html = file_get_contents(__DIR__ . '/../../html/registro.html');
        $this->data = ['login' => ''];
        $this->mensagem = '';
    }

    public function salvar($param)
    {
        try {
            $login = $param['login'];
            $senha = $param['senha'];
            $confirmar = $param['confirmar_senha'];


            $this->data['login'] = $login;

            if (empty($senha)) {
                $this->mensagem = "A senha é obrigatória.";
                return;
            }


            if (strlen($senha) < 6) {
                $this->mensagem = "A senha deve ter pelo menos 6 caracteres.";
                return;
            }


            if ($senha !== $confirmar) {
                $this->mensagem = "As senhas não coincidem.";
                return;
            }
            if (empty($login)) {
                $this->mensagem = "O login é obrigatório.";
                return;
            }
            if (empty($confirmar)) {
                $this->mensagem = "Confirme a senha.";
                return;
            }

            $existe = Usuario::findByLogin($login);
            if ($existe) {
                $this->mensagem = "Este login já está cadastrado.";
                return;
            }

            // Salvar
            $usuario = [
                'login' => $login,
                'senha' => $senha
            ];

            Usuario::save($usuario);

            // Redireciona
            header("Location: index.php?class=LoginForm");
            exit;

        } catch (Exception $e) {
            $this->mensagem = "Erro ao salvar: " . $e->getMessage();
        }
    }

    public function show()
    {
        $this->html = str_replace('{login}', $this->data['login'], $this->html);
        $this->html = str_replace('{mensagem}', $this->mensagem, $this->html);

        print $this->html;
    }
}