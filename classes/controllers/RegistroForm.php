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
        $this->data = ['nome' => '', 'email' => ''];
        $this->mensagem = '';
    }

    public function salvar($param)
    {
        try {
            // Verifica se e-mail já existe
            $existe = Usuario::findByEmail($param['email']);
            if ($existe) {
                $this->mensagem = "Este e-mail já está cadastrado.";
                $this->data = $param; // Mantém os dados no form
                return;
            }

            Usuario::save($param);
            // Salvo com sucesso, redireciona pro login
            header("Location: index.php?class=LoginForm");
            exit;
        } catch (Exception $e) {
            $this->mensagem = "Erro ao salvar: " . $e->getMessage();
        }
    }

    public function show()
    {
        $this->html = str_replace('{nome}', $this->data['nome'], $this->html);
        $this->html = str_replace('{email}', $this->data['email'], $this->html);
        $this->html = str_replace('{mensagem}', $this->mensagem, $this->html);
        print $this->html;
    }
}