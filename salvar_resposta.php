<?php
// Configuração do banco
$host = "localhost";
$user = "root";      // seu usuário do MySQL
$pass = "";          // sua senha
$db   = "meu_banco"; // nome do banco

// Conecta
$conn = new mysqli($host, $user, $pass, $db);

// Verifica erro
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Pega a resposta enviada
$resposta = $_POST['resposta'] ?? '';

// Salva no banco
if (!empty($resposta)) {
    $sql = "INSERT INTO respostas (escolha) VALUES ('$resposta')";
    if ($conn->query($sql) === TRUE) {
        echo "Salvo com sucesso!";
    } else {
        echo "Erro: " . $conn->error;
    }
} else {
    echo "Nenhuma resposta recebida!";
}

$conn->close();
?>
