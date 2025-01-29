<?php
session_start(); // Inicia a sessão para armazenar dados do carrinho e do usuário

// Lê a preferência de tema do cookie
$tema = isset($_COOKIE['tema']) ? $_COOKIE['tema'] : 'claro'; // Verifica se o cookie de tema existe, caso contrário, define como 'claro'

// Define a classe de tema com base na preferência do usuário
$temaClasse = $tema === 'escuro' ? 'escuro' : 'claro'; // Se o tema for 'escuro', atribui a classe 'escuro'; caso contrário, 'claro'

// Lógica para remover produto do carrinho
if (isset($_GET['remove'])) { // Verifica se há um item a ser removido
    $idRemover = $_GET['remove']; // Obtém o ID do item a ser removido

    if (isset($_SESSION['carrinho'][$idRemover])) { // Verifica se o item existe no carrinho
        // Decrementa a quantidade
        $_SESSION['carrinho'][$idRemover]['quantidade']--; // Diminui a quantidade do item

        // Se a quantidade chegar a zero, remove o item do carrinho
        if ($_SESSION['carrinho'][$idRemover]['quantidade'] <= 0) {
            unset($_SESSION['carrinho'][$idRemover]); // Remove o item do carrinho
        }
    }
}

// Lógica para remover todos os itens do carrinho
if (isset($_GET['remove_all'])) { // Verifica se a opção para remover todos os itens foi selecionada
    unset($_SESSION['carrinho']); // Remove todos os itens do carrinho
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres para o documento -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Configura a responsividade -->
    <title>Ver Carrinho</title> <!-- Título da página -->
    <link rel="stylesheet" href="view.css"> <!-- Link para o CSS principal -->
    <link rel="stylesheet" href="<?php echo $temaClasse; ?>.css"> <!-- Aplica o tema baseado na preferência do usuário -->
</head>
<body class="<?php echo $temaClasse; ?>"> <!-- Define a classe do corpo com base no tema -->
    <div class="container"> <!-- Div que contém o conteúdo do carrinho -->
        <h1>Seu Carrinho</h1> <!-- Cabeçalho da página -->

        <?php
        // Verifica se há itens no carrinho
        if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0) {
            $totalGeral = 0; // Inicializa o total geral
        ?>
        <table> <!-- Início da tabela para exibir os itens do carrinho -->
            <thead>
                <tr>
                    <th>Produto</th> <!-- Cabeçalho da coluna de produtos -->
                    <th>Preço Unitário</th> <!-- Cabeçalho da coluna de preço unitário -->
                    <th>Quantidade</th> <!-- Cabeçalho da coluna de quantidade -->
                    <th>Subtotal</th> <!-- Cabeçalho da coluna de subtotal -->
                    <th>Ações</th> <!-- Coluna para ações -->
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($_SESSION['carrinho'] as $id => $produto) { // Itera sobre os itens no carrinho
                    $subtotal = $produto['preco'] * $produto['quantidade']; // Calcula o subtotal do item
                    $totalGeral += $subtotal; // Adiciona ao total geral
                ?>
                <tr>
                    <td><?php echo $produto['nome']; ?></td> <!-- Nome do produto -->
                    <td>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td> <!-- Preço formatado do produto -->
                    <td><?php echo $produto['quantidade']; ?></td> <!-- Quantidade do produto -->
                    <td>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></td> <!-- Subtotal formatado -->
                    <td>
                        <a href="?remove=<?php echo $id; ?>">Remover Um</a> <!-- Link para remover um item do carrinho -->
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <p class="total"><strong>Total Geral: R$ <?php echo number_format($totalGeral, 2, ',', '.'); ?></strong></p> <!-- Exibe o total geral formatado -->
        
        <a href="?remove_all=true" class="remove-tudo">Remover Todos os Itens</a> <!-- Link para remover todos os itens do carrinho -->
        
        <?php
        } else {
            echo '<p class="carrinho-vazio">Seu carrinho está vazio.</p>'; // Mensagem para carrinho vazio
        }
        ?>

        <a href="add.php" class="voltar">Voltar à Loja</a> <!-- Link para voltar à loja -->
    </div>

    <footer>
        <p>Desenvolvido por Você</p> <!-- Mensagem de rodapé -->
    </footer>
</body>
</html>
