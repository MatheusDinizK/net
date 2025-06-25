<?php
// Ativar exibição de erros para debug (REMOVA OU COMENTE EM AMBIENTE DE PRODUÇÃO FINAL!)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inicia a sessão (essencial para as mensagens de feedback)
session_start();

// --- CONFIGURAÇÃO DO BANCO DE DADOS ---
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "netnucleo_db"; // Confirme que é o nome correto do seu banco de dados

// Tenta conectar ao banco de dados
$conn = new mysqli($servidor, $usuario, $senha, $banco);

// Verifica a conexão
if ($conn->connect_error) {
    $_SESSION['message'] = "Erro na conexão com o banco de dados: " . $conn->connect_error;
    $_SESSION['message_type'] = "danger";
    header("Location: cadastro_aula.php"); // Redireciona de volta
    exit();
}

// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Coletar e Sanitizar os Dados do Formulário
    $dataAula    = $conn->real_escape_string($_POST['dataAula']);
    $periodoAula = $conn->real_escape_string($_POST['periodoAula']);
    $instrutorId = (int)$_POST['instrutor'];
    $salaId      = (int)$_POST['sala'];
    $materiaId   = (int)$_POST['materia']; // Novo campo: ID da Matéria
    $turmaId     = (int)$_POST['turma'];   // Novo campo: ID da Turma
    $tipoAula    = $conn->real_escape_string($_POST['tipoAula']);
    $observacoes = isset($_POST['observacoes']) ? $conn->real_escape_string($_POST['observacoes']) : null;

    // 2. Validação Básica (Adicione mais validações conforme necessário)
    // Agora inclui materiaId e turmaId na validação de campos obrigatórios
    if (empty($dataAula) || empty($periodoAula) || empty($instrutorId) || empty($salaId) || empty($materiaId) || empty($turmaId) || empty($tipoAula)) {
        $_SESSION['message'] = "Por favor, preencha todos os campos obrigatórios (Data, Período, Instrutor, Sala, Matéria, Turma, Tipo de Aula).";
        $_SESSION['message_type'] = "danger";
        header("Location: cadastro_aula.php");
        exit();
    }

    // 3. Preparar e Executar a Inserção no Banco de Dados
    // ATENÇÃO: Confirme que 'aulas' é o nome da sua tabela e as colunas estão corretas
    // O SQL agora inclui id_materia e id_turma
    $sql = "INSERT INTO aulas (data_aula, periodo_aula, id_instrutor, id_sala, id_materia, id_turma, tipo_aula, observacoes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepara a declaração para evitar SQL Injection
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $_SESSION['message'] = "Erro na preparação da declaração: " . $conn->error;
        $_SESSION['message_type'] = "danger";
        header("Location: cadastro_aula.php");
        exit();
    }

    // Vincula os parâmetros à declaração
    // 'ssiiissi' -> s=string, i=integer (8 parâmetros agora: dataAula, periodoAula, instrutorId, salaId, materiaId, turmaId, tipoAula, observacoes)
    // Certifique-se da ordem e dos tipos corretos dos parâmetros!
    $stmt->bind_param("ssiiisis", $dataAula, $periodoAula, $instrutorId, $salaId, $materiaId, $turmaId, $tipoAula, $observacoes);

    // Executa a declaração
    if ($stmt->execute()) {
        $_SESSION['message'] = "Aula cadastrada com sucesso!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Erro ao cadastrar aula: " . $stmt->error;
        $_SESSION['message_type'] = "danger";
    }

    // Fecha a declaração
    $stmt->close();

} else {
    // Se a requisição não for POST, redireciona para a página de cadastro
    $_SESSION['message'] = "Método de requisição inválido.";
    $_SESSION['message_type'] = "danger";
}

// Fecha a conexão com o banco de dados
$conn->close();

// Redireciona de volta para a página de cadastro com a mensagem
header("Location: cadastro_aula.php");
exit();
?>