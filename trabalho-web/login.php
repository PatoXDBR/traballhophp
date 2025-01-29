<?php
session_start(); // Inicia a sessão para armazenar dados do usuário

// Processa o formulário de login e a escolha de tema
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Verifica se o método de requisição é POST
    $nomeUsuario = trim($_POST['nome']); // Remove espaços em branco do nome do usuário
    $tema = $_POST['tema']; // Obtém o tema escolhido pelo usuário

    // Verifica se o nome do usuário não está vazio
    if (!empty($nomeUsuario)) {
        $_SESSION['usuario'] = $nomeUsuario; // Armazena o nome do usuário na sessão

        // Salva o nome e o tema em cookies que expiram em 30 dias
        setcookie('nome_usuario', $nomeUsuario, time() + (30 * 24 * 60 * 60), "/"); // Cria um cookie para o nome do usuário
        setcookie('tema', $tema, time() + (30 * 24 * 60 * 60), "/"); // Cria um cookie para o tema escolhido

        // Redireciona para a página add.php após o login
        header('Location: add.php'); // Redireciona para a página de adição de produtos
        exit(); // Interrompe a execução do script
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres para o documento -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Configura a responsividade -->
    <title>Login</title> <!-- Título da página -->
    <link rel="stylesheet" href="view.css"> <!-- Link para o CSS principal -->
</head>
<body>
    <div class="container"> <!-- Div que contém o formulário de login -->
        <h1>Login</h1> <!-- Cabeçalho da página -->
        <form method="post"> <!-- Formulário que envia dados via método POST -->
            <label for="nome">Nome:</label> <!-- Rótulo para o campo de nome -->
            <input type="text" id="nome" name="nome" required> <!-- Campo de entrada para o nome do usuário -->
            <br>
            <label for="tema">Escolha o tema:</label> <!-- Rótulo para a seleção de tema -->
            <select id="tema" name="tema"> <!-- Menu suspenso para seleção do tema -->
                <option value="claro">Claro</option> <!-- Opção de tema claro -->
                <option value="escuro">Escuro</option> <!-- Opção de tema escuro -->
            </select>
            <br>
            <input type="submit" value="Entrar"> <!-- Botão de envio do formulário -->
        </form>
    </div>
</body>
</html>
