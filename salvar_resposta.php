<?php
// Configurações e CORS (Cross-Origin Resource Sharing)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// 1. VERIFICAÇÃO DO MÉTODO HTTP
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Retorna 405 Method Not Allowed se não for POST
    echo json_encode(["status" => "erro", "mensagem" => "Método não permitido. Use POST."]);
    exit();
}

// Configuração do banco
$host = "localhost";
$user = "root";
$pass = "";
$db   = "meu_banco"; 

// Conecta
$conn = new mysqli($host, $user, $pass, $db);

// Verifica erro de conexão
if ($conn->connect_error) {
    http_response_code(500); // Retorna erro interno do servidor
    echo json_encode(["status" => "erro", "mensagem" => "Erro na conexão com o banco: " . $conn->connect_error]);
    exit();
}

// 2. PEGA O JSON ENVIADO PELO 'fetch' DO JAVASCRIPT
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// 3. EXTRAI A RESPOSTA (com verificação)
$resposta = $data['resposta'] ?? ''; 

// Salva no banco
if (!empty($resposta)) {
    // Escapa a string para prevenir SQL Injection (MUITO IMPORTANTE!)
    $resposta_segura = $conn->real_escape_string($resposta);
    
    $sql = "INSERT INTO respostas (escolha) VALUES ('$resposta_segura')";
    
    if ($conn->query($sql) === TRUE) {
        http_response_code(200); // Sucesso
        echo json_encode(["status" => "sucesso", "mensagem" => "Salvo com sucesso!", "escolha" => $resposta]);
    } else {
        http_response_code(500); // Erro interno do servidor
        echo json_encode(["status" => "erro", "mensagem" => "Erro ao salvar: " . $conn->error]);
    }
} else {
    http_response_code(400); // Requisição inválida
    echo json_encode(["status" => "erro", "mensagem" => "Nenhuma resposta recebida no formato JSON."]);
}

$conn->close();
?>