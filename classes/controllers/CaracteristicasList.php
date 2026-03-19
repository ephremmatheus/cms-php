<?php
require_once __DIR__ . '/../models/CaracteristicaHome.php';

class CaracteristicasList
{

    private $html;

    public function __construct()
    {
        $this->html = file_get_contents(__DIR__ . '/../../html/caracteristicas/caracteristicaList.html');
    }

    public function delete($param)
    {
        try {
            $id = (int) $param['id'];
            CaracteristicaHome::delete($id);
            header("Location: index.php?class=DashboardForm&page=caracteristicaList");
            exit;
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }


    public function load()
    {
        try {
            $caracteristicas = CaracteristicaHome::all();
            $items = '';

            if (empty($caracteristicas)) {
                $items = '
                    <tr>
                        <td colspan="4" style="text-align:center;">
                            Nenhuma característica cadastrada.
                        </td>
                    </tr>
                ';
            } else {
                foreach ($caracteristicas as $caracteristica) {
                    $item = file_get_contents(__DIR__ . '/../../html/caracteristicas/caracteristicaItem.html');

                    $item = str_replace('{id}', $caracteristica['codigo_caracteristica'], $item);
                    $item = str_replace('{titulo}', $caracteristica['titulo'], $item);
                    $item = str_replace('{descricao}', $caracteristica['descricao'], $item);

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