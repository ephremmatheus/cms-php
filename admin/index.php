<?php
// 1. Inicia a sessão para todo o sistema
session_start();

// 2. Autoload inteligente (procura na raiz e na pasta classes)
spl_autoload_register(function ($class) {
    if (file_exists($class . '.php')) {
        require_once $class . '.php';
    } elseif (file_exists('classes/' . $class . '.php')) {
        require_once 'classes/' . $class . '.php';
    }
});

// 3. Define a classe padrão caso ninguém passe nada (ex: acessar a raiz do site)
$classe = isset($_REQUEST['class']) ? $_REQUEST['class'] : 'LoginForm';
$method = isset($_REQUEST['method']) ? $_REQUEST['method'] : null;

// 4. Instancia e executa
if (class_exists($classe)) {
    $pagina = new $classe(); // Removi o envio de $_REQUEST aqui, passamos no método
    if (!empty($method) && method_exists($classe, $method)) {
        $pagina->$method($_REQUEST);
    }
    $pagina->show();
} else {
    echo "Página não encontrada.";
}