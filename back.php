<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

try {
  // Exibe o conteúdo do POST para verificar se os dados chegaram
  var_dump($_POST);
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    if (empty($name) || empty($email) || empty($message)) {
      throw new Exception('Todos os campos são obrigatórios.');
    }

    $host = '127.0.0.1';
    $dbname = 'frontenduepb';
    $user = 'root';
    $pass = '';

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO contatos (name, email, message) VALUES (:name, :email, :message)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':message', $message);
    $stmt->execute();

    echo json_encode([
      'success' => true,
      'message' => 'Formulário enviado e salvo no banco de dados!'
    ]);
  } else {
    throw new Exception('Método de requisição inválido.');
  }
} catch (Exception $e) {
  echo json_encode([
    'success' => false,
    'message' => $e->getMessage()
  ]);
}
