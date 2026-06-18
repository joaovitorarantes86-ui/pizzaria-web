<?php
// dados de conexao com o banco
$host    = 'localhost';
$banco   = 'pizzaria';
$usuario = 'root';
$senha   = '';

try {
    // conexao pdo com mysql
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8mb4", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Erro na conexão com o banco: ' . $e->getMessage());
}