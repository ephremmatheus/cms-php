<?php
require_once __DIR__ . '/../models/Preferencia.php';

class PreferenciaList
{
    private $html;

    public function __construct()
    {
        $this->html = file_get_contents(__DIR__ . '/../../html/preferencias/list.html');
    }

    public function delete($param)
    {
        try {
            $id = $param['id'];
            Preferencia::delete($id);
            header("Location: index.php?class=DashboardForm&page=preferenciaList");
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function load()
    {
        try {
            $preferencias = Preferencia::all();
            $items = '';

            if (empty($preferencias)) {
                $items = '
                <tr>
                    <td colspan="8" style="text-align:center;">
                        Nenhuma preferência cadastrada.
                    </td>
                </tr>
            ';
            } else {
                foreach ($preferencias as $preferencia) {
                    $item = file_get_contents(__DIR__ . '/../../html/preferencias/item.html');

                    $item = str_replace('{id}', $preferencia['id'], $item);

                    $item = str_replace('{titulo_landing_page}', $preferencia['titulo_landing_page'], $item);

                    $favicon = '';
                    if (!empty($preferencia['favicon'])) {
                        $favicon = '<img src="../' . $preferencia['favicon'] . '" width="50" height="50">';
                    }
                    
                    $item = str_replace('{favicon}', $favicon, $item);

                    $logo = '';
                    if (!empty($preferencia['logo_cabecalho'])) {
                        $logo = '<img src="../' . $preferencia['logo_cabecalho'] . '" width="50" height="50">';
                    }

                    $item = str_replace('{logo_cabecalho}', $logo, $item);

                    $item = str_replace('{link_facebook}', $preferencia['link_facebook'], $item);
                    $item = str_replace('{link_instagram}', $preferencia['link_instagram'], $item);

                    $item = str_replace('{titulo_secao_home}', $preferencia['titulo_secao_home'], $item);
                    $item = str_replace('{subtitulo_secao_home}', $preferencia['subtitulo_secao_home'], $item);

                    $imagemHome = '';
                    if (!empty($preferencia['imagem_secao_home'])) {
                        $imagemHome = '<img src="../' . $preferencia['imagem_secao_home'] . '" width="50" height="50">';
                    }

                    $item = str_replace('{imagem_secao_home}', $imagemHome, $item);

                    $item = str_replace('{titulo_caracteristicas_home}', $preferencia['titulo_caracteristicas_home'], $item);

                    $item = str_replace('{titulo_secao_testemunho}', $preferencia['titulo_secao_testemunho'], $item);

                    $item = str_replace('{titulo_secao_loja_apps}', $preferencia['titulo_secao_loja_apps'], $item);
                    $item = str_replace('{subtitulo_secao_loja_apps}', $preferencia['subtitulo_secao_loja_apps'], $item);

                    $imagemLoja = '<img src="../Layout/images/teste.png">';
                    if (!empty($preferencia['imagem_secao_loja_apps'])) {
                        $imagemLoja = '<img src="../' . $preferencia['imagem_secao_loja_apps'] . '" width="50" height="50">';
                    }

                    $item = str_replace('{imagem_secao_loja_apps}', $imagemLoja, $item);

                    $item = str_replace('{link_appstore}', $preferencia['link_appstore'], $item);
                    
                    $imagemAppstore = '';
                    if (!empty($preferencia['imagem_appstore'])) {
                        $imagemAppstore = '<img src="../' . $preferencia['imagem_appstore'] . '" width="50" height="50">';
                    }

                    $item = str_replace('{imagem_appstore}', $imagemAppstore, $item);

                    $item = str_replace('{link_playstore}', $preferencia['link_playstore'], $item);

                    $imagemPlaystore = '';
                    if (!empty($preferencia['imagem_playstore'])) {
                        $imagemPlaystore = '<img src="../' . $preferencia['imagem_playstore'] . '" width="50" height="50">';
                    }
                    $item = str_replace('{imagem_playstore}', $imagemPlaystore, $item);

                    $item = str_replace('{telefone_contato}', $preferencia['telefone_contato'], $item);

                    $logoRodape = '';
                    if (!empty($preferencia['logo_rodape'])) {
                        $logoRodape = '<img src="../' . $preferencia['logo_rodape'] . '" width="50" height="50">';
                    }
                    $item = str_replace('{logo_rodape}', $logoRodape, $item);

                    $item = str_replace('{mensagem_copyright}', $preferencia['mensagem_copyright'], $item);
                    $item = str_replace('{url_rodape}', $preferencia['url_rodape'], $item);
                    $item = str_replace('{mensagem_powered}', $preferencia['mensagem_powered'], $item);

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
