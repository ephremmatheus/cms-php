<?php
require_once __DIR__ . '/../models/Preferencia.php';

class PreferenciaForm
{
    private $html;
    private $data;
    private $mensagem;

    public function __construct()
    {
        $this->html = file_get_contents(__DIR__ . '/../../html/preferencias/form.html');


        $preferencias = Preferencia::all();

        if (!empty($preferencias)) {

            $this->data = $preferencias[0];
        } else {

            $this->data = [
                'id' => null,
                'titulo_landing_page' => null,
                'favicon' => null,
                'logo_cabecalho' => null,
                'link_facebook' => null,
                'link_instagram' => null,
                'titulo_secao_home' => null,
                'subtitulo_secao_home' => null,
                'imagem_secao_home' => null,
                'titulo_caracteristicas_home' => null,
                'titulo_secao_testemunho' => null,
                'titulo_secao_loja_apps' => null,
                'subtitulo_secao_loja_apps' => null,
                'imagem_secao_loja_apps' => null,
                'link_appstore' => null,
                'imagem_appstore' => null,
                'link_playstore' => null,
                'imagem_playstore' => null,
                'telefone_contato' => null,
                'logo_rodape' => null,
                'mensagem_copyright' => null,
                'url_rodape' => null,
                'mensagem_powered' => null,
            ];
        }
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
            $preferencia = Preferencia::find($id);
            $this->data = $preferencia ?? $this->data;
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public function save($param)
    {
        try {

            if (empty($param['titulo_landing_page'])) {
                throw new Exception("Título da landing é obrigatório.");
            }

            if (empty($param['titulo_secao_home'])) {
                throw new Exception("Título da home é obrigatório.");
            }

            if (empty($param['telefone_contato'])) {
                throw new Exception("Telefone é obrigatório.");
            }

            $param['logo_cabecalho'] = $this->uploadImagem('logo_cabecalho', $this->data['logo_cabecalho']);

            $param['favicon'] = $this->uploadImagem('favicon', $this->data['favicon']);

            $param['imagem_secao_home'] = $this->uploadImagem('imagem_secao_home', $this->data['imagem_secao_home']);

            $param['imagem_secao_loja_apps'] = $this->uploadImagem('imagem_secao_loja_apps', $this->data['imagem_secao_loja_apps']);

            $param['imagem_appstore'] = $this->uploadImagem('imagem_appstore', $this->data['imagem_appstore']);

            $param['imagem_playstore'] = $this->uploadImagem('imagem_playstore', $this->data['imagem_playstore']);

            $param['logo_rodape'] = $this->uploadImagem('logo_rodape', $this->data['logo_rodape']);


            foreach ($param as $key => $value) {
                $param[$key] = trim($value);
            }

            Preferencia::save($param);
            $this->data = $param;
            header("Location: index.php?class=DashboardForm&page=preferenciaList");
            exit;
        } catch (Exception $e) {
        
            $_SESSION['mensagem'] = $e->getMessage();

            header("Location: index.php?class=DashboardForm&page=preferenciaList");
            exit;
        }
    }


    public function show()
    {

        $nomeLogo = $this->getNomeArquivo($this->data['logo_cabecalho']);
        $this->html = str_replace(
            '{nome_logo}',
            $nomeLogo ? '<small> Arquivo atual: ' . $nomeLogo . '</small>' : '',
            $this->html
        );
        $this->html = str_replace('{nome_logo}', $nomeLogo, $this->html);

        $this->html = str_replace('{id}', $this->data['id'], $this->html);
        $this->html = str_replace('{titulo_landing_page}', $this->data['titulo_landing_page'], $this->html);

        $nomeFavicon = $this->getNomeArquivo($this->data['favicon']);
        $this->html = str_replace(
            '{nome_favicon}',
            $nomeFavicon ? '<small> Arquivo atual: ' . $nomeFavicon . '</small>' : '',
            $this->html
        );
        $this->html = str_replace('{nome_favicon}', $nomeFavicon, $this->html);

        $this->html = str_replace('{link_facebook}', $this->data['link_facebook'], $this->html);
        $this->html = str_replace('{link_instagram}', $this->data['link_instagram'], $this->html);

        $this->html = str_replace('{titulo_secao_home}', $this->data['titulo_secao_home'], $this->html);
        $this->html = str_replace('{subtitulo_secao_home}', $this->data['subtitulo_secao_home'], $this->html);

        $nomeImagemHome = $this->getNomeArquivo($this->data['imagem_secao_home']);
        $this->html = str_replace(
            '{nome_imagem_home}',
            $nomeImagemHome ? '<small> Arquivo atual: ' . $nomeImagemHome . '</small>' : '',
            $this->html
        );
        $this->html = str_replace('{nome_imagem_home}', $nomeImagemHome, $this->html);

        $this->html = str_replace('{titulo_caracteristicas_home}', $this->data['titulo_caracteristicas_home'], $this->html);

        $this->html = str_replace('{titulo_secao_testemunho}', $this->data['titulo_secao_testemunho'], $this->html);

        $this->html = str_replace('{titulo_secao_loja_apps}', $this->data['titulo_secao_loja_apps'], $this->html);
        $this->html = str_replace('{subtitulo_secao_loja_apps}', $this->data['subtitulo_secao_loja_apps'], $this->html);

        $nomeImagemLoja = $this->getNomeArquivo($this->data['imagem_secao_loja_apps']);
        $this->html = str_replace(
            '{nome_imagem_loja}',
            $nomeFavicon ? '<small> Arquivo atual: ' . $nomeImagemLoja . '</small>' : '',
            $this->html
        );
        $this->html = str_replace('{nome_imagem_loja}', $nomeImagemLoja, $this->html);


        $this->html = str_replace('{link_appstore}', $this->data['link_appstore'], $this->html);

        $nomeImagemAppstore = $this->getNomeArquivo($this->data['imagem_appstore']);
        $this->html = str_replace(
            '{nome_imagem_appstore}',
            $nomeImagemAppstore ? '<small> Arquivo atual: ' . $nomeImagemAppstore . '</small>' : '',
            $this->html
        );
        $this->html = str_replace('{nome_imagem_appstore}', $nomeImagemAppstore, $this->html);

        $this->html = str_replace('{link_playstore}', $this->data['link_playstore'], $this->html);

        $nomeImagemPlaystore = $this->getNomeArquivo($this->data['imagem_playstore']);
        $this->html = str_replace(
            '{nome_imagem_playstore}',
            $nomeImagemPlaystore ? '<small> Arquivo atual: ' . $nomeImagemPlaystore . '</small>' : '',
            $this->html
        );
        $this->html = str_replace('{nome_imagem_playstore}', $nomeImagemPlaystore, $this->html);

        $this->html = str_replace('{telefone_contato}', $this->data['telefone_contato'], $this->html);

        $nomeLogoRodape = $this->getNomeArquivo($this->data['logo_rodape']);
        $this->html = str_replace(
            '{nome_logo_rodape}',
            $nomeLogoRodape ? '<small> Arquivo atual: ' . $nomeLogoRodape . '</small>' : '',
            $this->html
        );
        $this->html = str_replace('{nome_logo_rodape}', $nomeLogoRodape, $this->html);


        $this->html = str_replace('{mensagem_copyright}', $this->data['mensagem_copyright'], $this->html);
        $this->html = str_replace('{url_rodape}', $this->data['url_rodape'], $this->html);
        $this->html = str_replace('{mensagem_powered}', $this->data['mensagem_powered'], $this->html);

        print $this->html;
    }
}
?>