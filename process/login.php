<?php
session_start();
require_once '../includes/conexao.php';

// so aceita post
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.php');
    exit;
}

$erros = [];
$email  = trim($_POST['email'] ?? '');
$senha  = $_POST['senha'] ?? '';
$origem = $_POST['origem'] ?? '';

// validacao
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
    $erros[] = 'E-mail inválido.';

if (empty($senha) || strlen($senha) < 6)
    $erros[] = 'Senha deve ter pelo menos 6 caracteres.';

if (!empty($erros)) {
    $_SESSION['login_erros'] = $erros;
    $_SESSION['login_email'] = $email;
    $redir = $origem === 'admin' ? '../admin/login.php' : '../login.php';
    header("Location: $redir");
    exit;
}

// busca usuario no banco
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->execute([$email]);
$usuario = $stmt->fetch();

// verifica senha
if (!$usuario || !password_verify($senha, $usuario['senha'])) {
    $_SESSION['login_erros'] = ['E-mail ou senha incorretos.'];
    $_SESSION['login_email'] = $email;
    $redir = $origem === 'admin' ? '../admin/login.php' : '../login.php';
    header("Location: $redir");
    exit;
}

// admin tentando entrar como cliente
if ($origem === 'admin' && $usuario['tipo'] !== 'admin') {
    $_SESSION['login_erros'] = ['Acesso negado.'];
    header('Location: ../admin/login.php');
    exit;
}

// regenera id da sessao por seguranca
session_regenerate_id(true);

// salva dados na sessao
$_SESSION['usuario_id']   = $usuario['id'];
$_SESSION['usuario_nome'] = $usuario['nome'];
$_SESSION['usuario_tipo'] = $usuario['tipo'];
unset($_SESSION['login_erros'], $_SESSION['login_email']);

// redireciona conforme tipo
header($usuario['tipo'] === 'admin' ? 'Location: ../admin/index.php' : 'Location: ../pedidos.php');
exit;