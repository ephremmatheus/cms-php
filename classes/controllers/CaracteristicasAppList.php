<?php
require_once __DIR__ . '/../models/CaracteristicaApp.php';

class CaracteristicasAppList {

    private $html;

    // carrega o html da listagem
    public function __construct() {
        $this->html = file_get_contents(__DIR__ . '/../../html/caracteristicasApp/caracteristicaAppList.html');
    }

    // apaga uma característica e volta pra lista
    public function delete($param) {
        try {
            $id = (int) $param['id'];
            CaracteristicaApp::delete($id);
            header("Location: index.php?class=DashboardForm&page=caracteristicaAppList");
            exit;
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    // busca todos os registros do banco e monta as linhas da tabela
    public function load() {
        try {
            $caracteristicas = CaracteristicaApp::all();
            $items = '';

            if (empty($caracteristicas)) {
                // se não tiver nenhum registro, mostra uma mensagem na tabela
                $items = '
                    <tr>
                        <td colspan="4" style="text-align:center;">
                            Nenhuma característica cadastrada.
                        </td>
                    </tr>
                ';
            } else {
                // pra cada característica, lê o template de uma linha e substitui os placeholders
                foreach ($caracteristicas as $caracteristica) {
                    $item = file_get_contents(__DIR__ . '/../../html/caracteristicasApp/caracteristicaAppItem.html');

                    $item = str_replace('{id}',       $caracteristica['codigo_caracteristica_app'], $item);
                    $item = str_replace('{titulo}',   $caracteristica['titulo'],                    $item);
                    $item = str_replace('{descricao}',$caracteristica['descricao'],                 $item);

                    $items .= $item;
                }
            }

            $this->html = str_replace('{items}', $items, $this->html);

        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    // chama o load e exibe o html na tela
    public function show() {
        $this->load();
        print $this->html;
    }
}