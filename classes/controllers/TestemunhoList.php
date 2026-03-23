<?php

require_once __DIR__ . '/../models/Testemunho.php';

class TestemunhoList
{
    private $html;

    public function __construct()
    {
        $this->html = file_get_contents(__DIR__ . '/../../html/testemunho/testemunhoList.html');
    }

    public function delete($param)
    {
        try {
            $id = (int) $param['id'];
            Testemunho::delete($id);
            header("Location: index.php?class=DashboardForm&page=testemunhoList");
            exit;
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function load()
    {
        try {
            $testemunhos = Testemunho::all();
            $items = '';

            if (empty($testemunhos)) {
                $items = '
                <tr>
                    <td colspan="8" style="text-align:center;">
                        Nenhum testemunho cadastrado.
                    </td>
                </tr>
            ';
            } else {
                foreach ($testemunhos as $testemunho) {
                    $item = file_get_contents(__DIR__ . '/../../html/testemunho/testemunhoItem.html');

                    $item = str_replace('{id}', $testemunho['codigo_testemunho'], $item);
                    $item = str_replace('{nome}', $testemunho['nome'], $item);
                    $item = str_replace('{funcao}', $testemunho['funcao'], $item);
                    $item = str_replace('{titulo}', $testemunho['titulo'], $item);
                    $item = str_replace('{descricao}', $testemunho['descricao'], $item);

                    $foto = '';
                    if (!empty($testemunho['foto'])) {
                        $foto = '<img src="../' . $testemunho['foto'] . '" width="50" height="50">';
                    }
                    $item = str_replace('{foto}', $foto, $item);

                    $imagemFundo = '';
                    if (!empty($testemunho['imagem_fundo'])) {
                        $imagemFundo = '<img src="../' . $testemunho['imagem_fundo'] . '" width="50" height="50">';
                    }
                    $item = str_replace('{imagem_fundo}', $imagemFundo, $item);

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
        $mensagemHtml = '';

        if (!empty($_SESSION['mensagem'])) {
            $mensagemHtml = '<div class="alert alert-danger">' . $_SESSION['mensagem'] . '</div>';
            unset($_SESSION['mensagem']);
        }

        $this->html = str_replace('{mensagem}', $mensagemHtml, $this->html);

        $this->load();
        print $this->html;
    }
}