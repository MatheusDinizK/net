<?php
// Arquivo: conexao.php

// 1. Defina suas credenciais do banco de dados
$servidor = "localhost"; // Geralmente 'localhost' se o banco estiver no mesmo servidor
$usuario = "root";       // Usuário padrão do XAMPP/WAMP (se você usa)
$senha = "";             // Senha padrão do XAMPP/WAMP (geralmente vazia)
$banco = "netnucleo_db"; // **IMPORTANTE: Substitua 'netnucleo' pelo nome real do seu banco de dados!**

// 2. Tenta estabelecer a conexão com o banco de dados
$conn = new mysqli($servidor, $usuario, $senha, $banco);

// 3. Verifica se houve algum erro na conexão
if ($conn->connect_error) {
    // Se houver erro, exibe uma mensagem e encerra o script
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// 4. Opcional: Define o conjunto de caracteres para UTF-8 (boas práticas para evitar problemas de acentuação)
$conn->set_charset("utf8");

// A conexão ($conn) agora está estabelecida e será automaticamente fechada quando o script PHP terminar,
// ou você pode fechá-la explicitamente com $conn->close(); ao final da sua página.
?>