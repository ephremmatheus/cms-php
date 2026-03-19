<?php
require_once __DIR__ . '/../models/Contato.php';

class ContatoForm
{
    private $html;
    private $data;

    public function __construct()
    {
        $this->html = file_get_contents(__DIR__ . '/../../html/contato/form.html');
        $this->data = [
            'codigo_mensagem' => null,
            'nome' => null,
            'email' => null,
            'telefone' => null,
            'mensagem' => null
        ];
    }

    public function edit($param)
    {
        try {
            $codigo_mensagem = (int) $param['codigo_mensagem'];
            $contato = Contato::find($codigo_mensagem);
            $this->data = $contato ?? $this->data;
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function save($param)
    {
        try {
            $nome = trim(($param['nome']));

            if (empty($nome)) {
                throw new Exception("O nome é obrigatório.");
            }

            if (strlen($nome) < 3) {
                throw new Exception("O nome deve ter pelo menos 3 caracteres.");
            }

            $email = trim($param['email']);

            if (empty($email)) {
                throw new Exception("O email é obrigatório.");
            }

            $telefone = trim($param['telefone']);

            if (empty($telefone)) {
                print "telefone inválido.";
                exit;
            }

            $mensagem = trim($param['mensagem']);

            if (empty($mensagem)) {
                throw new Exception("A mensagem é obrigatória.");
            }

            if (strlen($nome) > 100) {
                throw new Exception("Nome muito longo.");
            }

            if (strlen($email) > 150) {
                throw new Exception("Email muito longo.");
            }

            if (strlen($mensagem) > 1000) {
                throw new Exception("Mensagem muito longa.");
            }

            if (!isset($param['nome'], $param['email'], $param['mensagem'])) {
                throw new Exception("Dados incompletos.");
            }

            Contato::save($param);
            $this->data = $param;
            header("Location: index.php?class=DashboardForm&page=contatoList");
            exit;
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function show()
    {
        $this->html = str_replace('{codigo_mensagem}', $this->data['codigo_mensagem'] ?? '', $this->html);
        $this->html = str_replace('{nome}', $this->data['nome'], $this->html);
        $this->html = str_replace('{email}', $this->data['email'], $this->html);
        $this->html = str_replace('{telefone}', $this->data['telefone'], $this->html);
        $this->html = str_replace('{mensagem}', $this->data['mensagem'], $this->html);

        print $this->html;
    }
}
?>