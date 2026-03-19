<?php

class DashboardForm
{
    private $html;

    public function __construct()
    {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?class=LoginForm");
            exit;
        }

        $this->html = file_get_contents(__DIR__ . '/../../html/dashboard.html');
    }

    public function show($param = [])
    {
        $login = $_SESSION['usuario_login'];

        // 🔐 menu usuarios
        if ($_SESSION['usuario_id'] == 1) {
            $menuUsuarios = '
                <li class="list-group-item">
                    <a href="index.php?class=DashboardForm&page=usuarioList">Usuários</a>
                </li>
            ';
        } else {
            $menuUsuarios = '';
        }


        $conteudo = '';

        if (isset($param['page'])) {
            $pagina = $param['page'];

            if ($pagina == 'testemunhoList') {
                $controller = new TestemunhoList();
                ob_start();
                $controller->show();
                $conteudo = ob_get_clean();
            } else if ($pagina == 'preferenciaList') {
                $controller = new PreferenciaList();
                ob_start();
                $controller->show();
                $conteudo = ob_get_clean();
            } else if ($pagina == 'caracteristicaList') {
                // carrega o controller de características e exibe a listagem
                $controller = new CaracteristicasList();
                ob_start();
                $controller->show();
                $conteudo = ob_get_clean();
            } else if ($pagina == 'usuarioList') {
                $controller = new UsuarioList();
                ob_start();
                $controller->show();
                $conteudo = ob_get_clean();
            } else if ($pagina == 'contatoList') {
                $controller = new ContatoList();
                ob_start();
                $controller->show();
                $conteudo = ob_get_clean();
            } else {
                $conteudo = "<p>Página não encontrada</p>";
            }
        } else {
            $conteudo = '
<div class="container mt-4">

  <div class="card shadow border-0">
    <div class="card-body">

      <h3 class="mb-3 text-primary fw-bold">Bem-vindo ao seu CMS 🚀</h3>

      <p class="text-muted">
        Este é o painel de gerenciamento da sua landing page. Aqui você pode administrar
        conteúdos, depoimentos, características da página inicial e mensagens de contato.
      </p>

      <hr>

      <div class="row g-3 mt-2">

        <div class="col-md-3">
          <div class="p-3 bg-light rounded shadow-sm h-100">
            <h5 class="fw-semibold">👤 Usuários</h5>
            <p class="small text-muted mb-0">
              Controle de acesso ao sistema e permissões administrativas.
            </p>
          </div>
        </div>

        <div class="col-md-3">
          <div class="p-3 bg-light rounded shadow-sm h-100">
            <h5 class="fw-semibold">💬 Testemunhos</h5>
            <p class="small text-muted mb-0">
              Gerencie depoimentos exibidos na landing page.
            </p>
          </div>
        </div>

        <div class="col-md-3">
          <div class="p-3 bg-light rounded shadow-sm h-100">
            <h5 class="fw-semibold">⭐ Características</h5>
            <p class="small text-muted mb-0">
              Destaques da home, como benefícios e diferenciais do produto.
            </p>
          </div>
        </div>

        <div class="col-md-3">
          <div class="p-3 bg-light rounded shadow-sm h-100">
            <h5 class="fw-semibold">⚙️ Preferências</h5>
            <p class="small text-muted mb-0">
              Configurações gerais do sistema e personalizações.
            </p>
          </div>
        </div>

        <div class="col-md-6">
          <div class="p-3 bg-light rounded shadow-sm h-100">
            <h5 class="fw-semibold">📩 Contato</h5>
            <p class="small text-muted mb-0">
              Visualize e gerencie mensagens enviadas pelos usuários através da landing page.
            </p>
          </div>
        </div>

        <div class="col-md-6">
          <div class="p-3 bg-light rounded shadow-sm h-100">
            <h5 class="fw-semibold">🌐 Landing Page</h5>
            <p class="small text-muted mb-0">
              Todo o conteúdo gerenciado aqui reflete diretamente na sua página pública.
            </p>
          </div>
        </div>

      </div>

    </div>
  </div>

</div>
';
        }

        // 🔄 replace
        $this->html = str_replace('{login}', $login, $this->html);
        $this->html = str_replace('{menu_usuarios}', $menuUsuarios, $this->html);
        $this->html = str_replace('{conteudo}', $conteudo, $this->html);

        print $this->html;
    }

    public function sair()
    {
        session_unset();
        session_destroy();

        header("Location: index.php?class=LoginForm");
        exit;
    }
}