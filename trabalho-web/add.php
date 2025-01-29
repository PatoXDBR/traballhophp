<?php
session_start(); // Inicia a sessão para armazenar dados do carrinho e preferências do usuário

// Lê a preferência de tema do cookie, se existir; caso contrário, usa o tema 'claro' como padrão
$tema = isset($_COOKIE['tema']) ? $_COOKIE['tema'] : 'claro';

// Define a classe de tema com base na preferência do usuário
$temaClasse = $tema == 'escuro' ? 'escuro' : 'claro';

// Cria o array associativo de produtos (mercadorias) com detalhes de cada camiseta
$mercadorias = [
    ['camisa' => 1, 'nome' => "Vitoria", 'preco' => 120.00, 'imagem' => "src/camisa-vitoria.webp"],
    ['camisa' => 2, 'nome' => "Corinthians", 'preco' => 180.00, 'imagem' => "src/camisa-corinthians.webp"],
    ['camisa' => 3, 'nome' => "Flamengo", 'preco' => 200.00, 'imagem' => "src/camisa-flamengo.webp"],
    ['camisa' => 4, 'nome' => "Borussia", 'preco' => 150.00, 'imagem' => "src/camisa-borussia.webp"],
    ['camisa' => 5, 'nome' => "Arsenal", 'preco' => 220.00, 'imagem' => "src/camisa-arsenal.webp"],
    ['camisa' => 6, 'nome' => "Boca Juniors", 'preco' => 150.00, 'imagem' => "src/camisa-boca.webp"]
];

// Verifica se o parâmetro 'add' foi passado pela URL para adicionar um produto ao carrinho
if (isset($_GET['add'])) {
    $id = $_GET['add']; // Obtém o ID do produto a ser adicionado
    $produtoSelecionado = null; // Inicializa a variável para armazenar o produto selecionado

    // Loop para encontrar o produto correspondente ao ID
    foreach ($mercadorias as $produto) {
        if ($produto['camisa'] == $id) {
            $produtoSelecionado = $produto; // Armazena o produto selecionado
            break; // Sai do loop ao encontrar o produto
        }
    }

    // Se o produto foi encontrado, adiciona ao carrinho
    if ($produtoSelecionado) {
        // Verifica se o produto já está no carrinho
        if (isset($_SESSION['carrinho'][$id])) {
            $_SESSION['carrinho'][$id]['quantidade']++; // Aumenta a quantidade se já estiver no carrinho
        } else {
            // Caso contrário, adiciona o produto ao carrinho com quantidade inicial 1
            $_SESSION['carrinho'][$id] = [
                'nome' => $produtoSelecionado['nome'],
                'preco' => $produtoSelecionado['preco'],
                'quantidade' => 1
            ];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres para o documento -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Configura a responsividade -->
    <title>Vitrine</title> <!-- Título da página -->
    <link rel="stylesheet" href="view.css"> <!-- Link para o CSS principal -->
    <link rel="stylesheet" href="<?php echo $temaClasse; ?>.css"> <!-- Aplica o tema de acordo com a preferência do usuário -->
</head>
<body class="<?php echo $temaClasse; ?>"> <!-- Aplica a classe de tema ao corpo da página -->
    <h1>Vitrine de Produtos</h1> <!-- Cabeçalho da página -->
    <div class="produtos"> <!-- Div para conter a lista de produtos -->
        <?php foreach ($mercadorias as $produto): ?> <!-- Loop para exibir cada produto -->
            <div class="produto"> <!-- Div individual para cada produto -->
                <img src="<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['nome']; ?>" width="200"> <!-- Imagem do produto -->
                <h2><?php echo $produto['nome']; ?></h2> <!-- Nome do produto -->
                <p>Preço: R$<?php echo number_format($produto['preco'], 2, ',', '.'); ?></p> <!-- Preço formatado do produto -->
                <a href="?add=<?php echo $produto['camisa']; ?>">Adicionar ao Carrinho</a> <!-- Link para adicionar produto ao carrinho -->
            </div>
        <?php endforeach; ?> <!-- Fim do loop de produtos -->
    </div>
    <a href="view.php">Ver Carrinho</a> <!-- Link para visualizar o carrinho -->
    <br>
    <a href="login.php">Voltar para Login</a> <!-- Link para retornar à página de login -->
</body>
</html>