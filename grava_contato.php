<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php 
        $host = 'localhost';
        $db = 'senai_ta_aulaphp';
        $user = 'thiago';
        $pass = '123456';
        $port = 3307; // Porta MySQL correta
        // Inclui o arquivo da classe Database que criamos para conectar dentro da pasta php
        require_once 'connection.php';
        // Cria uma instância da classe Database
        $database = new Database($host, $db, $user, $pass, $port);
        // Chama o método connect para estabelecer a conexão
        $database->connect();
        // Obtém a instância PDO para realizar consultas
        $pdo = $database->getConnection();
    ?>
</head>
<body>
<?php
// Verifica se os dados foram enviados via GET
if (isset($_GET['nome']) && isset($_GET['idade']) && isset($_GET['email']) && isset($_GET['cpf']) ) {
    // Captura os dados enviados pelo formulário
    $nome = htmlspecialchars($_GET['nome']);
    $email = htmlspecialchars($_GET['email']);
    $cpf = htmlspecialchars($_GET['cpf']);
    $idade = htmlspecialchars($_GET['idade']);

    if ($pdo) {
        try {
            // Prepara uma consulta SQL para selecionar as colunas 'id' e 'nome' da tabela 'usuario'
            $stmt = $pdo->prepare("INSERT into dados(nome, idade, email, cpf) values('$nome', '$idade', '$email', '$cpf');");
            
            // Executa a consulta preparada
            $stmt->execute();
 
            
        } catch (PDOException $e) {
            // Captura e exibe qualquer exceção (erro) que possa ocorrer durante a consulta ao banco de dados
            echo "Erro ao consultar o banco de dados: " . $e->getMessage() . "<br>";
        }
    }
    
// Supondo que $pdo é sua conexão PDO já configurada corretamente
$query = "SELECT nome, email, cpf, idade FROM senai_ta_aulaphp.dados";
$stmt = $pdo->query($query);

// Verifica se a consulta retornou alguma linha
if ($stmt->rowCount() > 0) {
    echo "<h2>Competidores:</h2>";

    // Itera sobre as linhas retornadas
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<p><strong>Nome:</strong> " . htmlspecialchars($row['nome']) . "</p>";
        echo "<hr>"; // Linha para separar cada registro
    }
} else {
    echo "Nenhum dado encontrado.";
}




} else {
    echo "Nenhum dado foi enviado.";
}
?>
</body>
</html>