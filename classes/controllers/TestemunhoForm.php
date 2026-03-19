<?php

require_once __DIR__ . '/../models/Testemunho.php';

class TestemunhoForm
{
    private $html;
    private $data;

    public function __construct()
    {
        $this->html = file_get_contents(__DIR__ . '/../../html/testemunho/testemunhoForm.html');
        $this->data = [
            'codigo_testemunho' => null,
            'nome' => null,
            'funcao' => null,
            'titulo' => null,
            'descricao' => null,
            'foto' => null,
            'imagem_fundo' => null,
        ];
    }

    public function edit($param)
    {
        try {
            $id = (int) $param['id'];
            $testemunho = Testemunho::find($id);
            $this->data = $testemunho;

        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function save($param)
    {
        try {
            if (empty(trim($param['nome']))) {
                throw new Exception("O nome é obrigatório.");
            }

            if (empty(trim($param['funcao']))) {
                throw new Exception("A função é obrigatória.");
            }

            if (empty(trim($param['titulo']))) {
                throw new Exception("O título é obrigatório.");
            }

            if (empty(trim($param['descricao']))) {
                throw new Exception("A descrição é obrigatória.");
            }

            if (empty(trim($param['foto']))) {
                throw new Exception("A foto é obrigatória.");
            }

            if (empty(trim($param['imagem_fundo']))) {
                throw new Exception("A imagem de fundo é obrigatória.");
            }
            Testemunho::save($param);
            $this->data = $param;
            header("Location: index.php?class=DashboardForm&page=testemunhoList");
            exit;
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }
    public function show()
    {
        $this->html = str_replace('{codigo_testemunho}', $this->data['codigo_testemunho'], $this->html);
        $this->html = str_replace('{nome}', $this->data['nome'], $this->html);
        $this->html = str_replace('{funcao}', $this->data['funcao'], $this->html);
        $this->html = str_replace('{titulo}', $this->data['titulo'], $this->html);
        $this->html = str_replace('{descricao}', $this->data['descricao'], $this->html);
        $this->html = str_replace('{foto}', $this->data['foto'], $this->html);
        $this->html = str_replace('{imagem_fundo}', $this->data['imagem_fundo'], $this->html);

        print $this->html;
    }
}