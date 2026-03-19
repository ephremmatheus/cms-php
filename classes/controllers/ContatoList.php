<?php
require_once __DIR__ . '/../models/Contato.php';

class ContatoList
{
    private $html;

    public function __construct()
    {
        $this->html = file_get_contents(__DIR__ . '/../../html/contato/list.html');
    }

    public function delete($param)
    {
        try {
            $id = (int) $param['id'];
            Contato::delete($id);

            header("Location: index.php?class=DashboardForm&page=contatoList");
            exit;
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function load()
    {
        try {
            $contatos = Contato::all();
            $items = '';

            if (empty($contatos)) {
                $items = '
                <tr>
                    <td colspan="7" style="text-align:center;">
                        Nenhuma mensagem encontrada.
                    </td>
                </tr>
                ';
            } else {
                foreach ($contatos as $contato) {
                    $item = file_get_contents(__DIR__ . '/../../html/contato/item.html');

                    $item = str_replace('{id}', $contato['codigo_mensagem'], $item);
                    $item = str_replace('{nome}', $contato['nome'], $item);
                    $item = str_replace('{email}', $contato['email'], $item);
                    $item = str_replace('{telefone}', $contato['telefone'], $item);
                    $item = str_replace('{mensagem}', $contato['mensagem'], $item);
                    $item = str_replace('{data}', $contato['data'], $item);

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
        $this->load();
        print $this->html;
    }
}
?>