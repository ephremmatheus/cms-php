<?php 
$mensagem_sucesso = "";
require_once __DIR__ . '/../classes/Database.php';

$conn = Database::getConnection(); 

// se o formulário de contato foi enviado, salva no banco
if (isset($_POST['action']) || isset($_GET['action'])) {
    $action = $_POST['action'] ?? $_GET['action'];

    if ($action == 'contato') {
        $nome     = trim($_POST['nome']);
        $email    = trim($_POST['email']);
        $telefone = trim($_POST['telefone']);
        $mensagem = trim($_POST['mensagem']);

        // remove tudo que não for número do telefone
        $telefone_numeros = preg_replace('/[^0-9]/', '', $telefone);

        // verifica se algum campo está vazio
        if (empty($nome) || empty($email) || empty($telefone) || empty($mensagem)) {
            $mensagem_sucesso = "incompleto";

        // verifica se o telefone tem entre 10 e 11 dígitos (com DDD)
        } elseif (strlen($telefone_numeros) < 10 || strlen($telefone_numeros) > 11) {
            $mensagem_sucesso = "telefone_invalido";

        } else {
            $stmt = $conn->prepare("INSERT INTO mensagens_contato (nome, email, telefone, mensagem, data) 
                                    VALUES (:nome, :email, :telefone, :mensagem, :data)");
            $stmt->execute([
                ':nome'     => $nome,
                ':email'    => $email,
                ':telefone' => $telefone_numeros, // salva só os números
                ':mensagem' => $mensagem,
                ':data'     => date('Y-m-d H:i:s'),
            ]);

            $mensagem_sucesso = "Mensagem enviada com sucesso!";
        }
    }
}

//busca as preferências cadastradas no cms (pega a primeira linha)
$stmt = $conn->prepare('SELECT * FROM preferencias LIMIT 1');
$stmt->execute();
$pref = $stmt->fetch(PDO::FETCH_ASSOC);

//busca todas as caracteristicas da seção home
$stmt2 = $conn->prepare('SELECT * FROM caracteristicas_home');
$stmt2 ->execute();
$caracteristicas= $stmt2->fetchAll(PDO::FETCH_ASSOC);

// busca todas as características da seção aplicativo
$stmt4 = $conn->prepare('SELECT * FROM caracteristicas_aplicativo');
$stmt4->execute();
$caracteristicasApp = $stmt4->fetchAll(PDO::FETCH_ASSOC);

//busca todos os testemunhos
$stmt3 = $conn->prepare('SELECT * FROM testemunhos');
$stmt3 ->execute();
$testemunhos = $stmt3->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/index.html';

?>


