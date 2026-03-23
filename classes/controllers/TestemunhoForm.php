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

    private function uploadImagem($campo, $valorAtual = null){
        if (!empty($_FILES[$campo]['name'])) {


        
            $arquivo = $_FILES[$campo];


            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp', 'image/x-icon'];

            if (!in_array($arquivo['type'], $tiposPermitidos)) {
                throw new Exception('Apenas imagens são permitidas');  
            }

            $nome = uniqid() . '_' . $arquivo['name'];
            $tmp = $arquivo['tmp_name'];

            $pastaFisica = __DIR__ . '/../../Layout/images/';
            $caminho = 'Layout/images/' . $nome;

            if (!is_dir($pastaFisica)) {
                mkdir($pastaFisica, 0777, true);
            }

            move_uploaded_file($tmp, $pastaFisica . $nome);

            return $caminho;

        }
    return $valorAtual; 
    }

    private function getNomeArquivo($caminho){
        if (empty($caminho)) return '';

        $nome = basename($caminho);

        $partes = explode('_', $nome);

        return $partes[1] ?? $nome;
    }

    public function edit($param)
    {
        try {
            $id = (int) $param['id'];
            $testemunho = Testemunho::find($id);
            $this->data = $testemunho ?? $this->data;

        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function save($param)
{
    try {
        // Se estiver editando, carrega os dados atuais do registro
        if (!empty($param['codigo_testemunho'])) {
            $id = (int)$param['codigo_testemunho'];
            $this->data = Testemunho::find($id);
        }

        // Valida campos obrigatórios
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

        // Faz upload das imagens se houver, senão mantém as atuais
        $param['foto'] = $this->uploadImagem('foto', $this->data['foto'] ?? null);
        $param['imagem_fundo'] = $this->uploadImagem('imagem_fundo', $this->data['imagem_fundo'] ?? null);

        // Salva ou atualiza o registro
        Testemunho::save($param);

        // Atualiza os dados locais (opcional)
        $this->data = $param;

        // Redireciona para a lista
        header("Location: index.php?class=DashboardForm&page=testemunhoList");
        exit;

    } catch (Exception $e) {
        // Armazena mensagem de erro e redireciona
        $_SESSION['mensagem'] = $e->getMessage();
        header("Location: index.php?class=DashboardForm&page=testemunhoList");
        exit;
    }

    }
    public function show()
    {
        $this->html = str_replace('{codigo_testemunho}', $this->data['codigo_testemunho'], $this->html);
        $this->html = str_replace('{nome}', $this->data['nome'], $this->html);
        $this->html = str_replace('{funcao}', $this->data['funcao'], $this->html);
        $this->html = str_replace('{titulo}', $this->data['titulo'], $this->html);
        $this->html = str_replace('{descricao}', $this->data['descricao'], $this->html);

        $nomeFoto = $this->getNomeArquivo($this->data['foto']);
        $this->html = str_replace(
            '{nome_foto}',
            $nomeFoto ? '<small> Arquivo atual: ' . $nomeFoto . '</small>' : '',
            $this->html
        );
        $this->html = str_replace('{nome_foto}', $nomeFoto, $this->html);

        $nomeImagemFundo = $this->getNomeArquivo($this->data['imagem_fundo']);
        $this->html = str_replace(
            '{nome_imagem_fundo}',
            $nomeImagemFundo ? '<small> Arquivo atual: ' . $nomeImagemFundo . '</small>' : '',
            $this->html
        );
        $this->html = str_replace('{nome_imagem_fundo}', $nomeImagemFundo, $this->html);

        print $this->html;
    }
}