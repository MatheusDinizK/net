<?php
// Certifica-se de que session_start() está na primeira linha para lidar com mensagens de sessão
session_start();

// ATIVAR EXIBIÇÃO DE ERROS PARA DEBUG (REMOVA OU COMENTE EM AMBIENTE DE PRODUÇÃO FINAL!)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); // Exibe todos os erros PHP

// Define o título da página
$pageTitle = "Cadastro de Aula";

// --- CONEXÃO COM O BANCO DE DADOS ---
// Verifique se estas credenciais estão CORRETAS para o seu ambiente (XAMPP/WAMP/Laragon)
$servidor = "localhost";    // Geralmente 'localhost'
$usuario = "root";          // Seu usuário do banco de dados (comum ser 'root')
$senha = "";                // Sua senha do banco de dados (comum ser vazia '' no XAMPP/WAMP padrão)
$banco = "netnucleo_db";    // NOME DO SEU BANCO DE DADOS - Confirme que é EXATEMANTE 'netnucleo_db'

// Tenta estabelecer a conexão
$conn = new mysqli($servidor, $usuario, $senha, $banco);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    // Se houver erro, encerra o script e exibe a mensagem de erro formatada como comentário HTML
    die("");
} else {
    // Esta mensagem só aparecerá no código-fonte da página (Ctrl+U) ou na aba Network do F12
    echo "";
}

// --- Lógica para buscar Instrutores do Banco de Dados ---
$instrutores = []; // Array para armazenar os instrutores
// CORRIGIDO: Nome da tabela para 'instrutores' e colunas para 'id_instrutor' e 'nome_instrutor'
$sql_instrutores = "SELECT id_instrutor AS id, nome_instrutor AS nome FROM instrutores ORDER BY nome_instrutor ASC"; 
$result_instrutores = $conn->query($sql_instrutores);

if (!$result_instrutores) {
    // Se houver erro na consulta, registra no debug
    echo "";
} else {
    if ($result_instrutores->num_rows > 0) {
        echo "";
        while ($row = $result_instrutores->fetch_assoc()) {
            $instrutores[] = $row;
        }
    } else {
        echo "";
    }
}

// --- Lógica para buscar Salas do Banco de Dados ---
$salas = []; // Array para armazenar as salas
// CORRIGIDO: Nome da tabela para 'salas' e colunas para 'id_sala' e 'nome_sala'
$sql_salas = "SELECT id_sala AS id, nome_sala AS nome FROM salas ORDER BY nome_sala ASC"; 
$result_salas = $conn->query($sql_salas);

if (!$result_salas) {
    // Se houver erro na consulta, registra no debug
    echo "";
} else {
    if ($result_salas->num_rows > 0) {
        echo "";
        while ($row = $result_salas->fetch_assoc()) {
            $salas[] = $row;
        }
    } else {
        echo "";
    }
}

// --- Lógica para buscar Matérias do Banco de Dados --- (ADICIONADO)
$materias = []; // Array para armazenar as matérias
// Assumindo que você tem uma tabela 'materias' com 'id_materia' e 'nome_materia'
$sql_materias = "SELECT id_materia AS id, nome_materia AS nome FROM materias ORDER BY nome_materia ASC"; 
$result_materias = $conn->query($sql_materias);

if (!$result_materias) {
    echo "";
} else {
    if ($result_materias->num_rows > 0) {
        echo "";
        while ($row = $result_materias->fetch_assoc()) {
            $materias[] = $row;
        }
    } else {
        echo "";
    }
}

// --- Lógica para buscar Turmas do Banco de Dados --- (ADICIONADO)
$turmas = []; // Array para armazenar as turmas
// Assumindo que você tem uma tabela 'turmas' com 'id_turma' e 'nome_turma'
$sql_turmas = "SELECT id_turma AS id, nome_turma AS nome FROM turmas ORDER BY nome_turma ASC"; 
$result_turmas = $conn->query($sql_turmas);

if (!$result_turmas) {
    echo "";
} else {
    if ($result_turmas->num_rows > 0) {
        echo "";
        while ($row = $result_turmas->fetch_assoc()) {
            $turmas[] = $row;
        }
    } else {
        echo "";
    }
}

// Definição de variáveis PHP para o cabeçalho (exemplo, ajuste conforme seu sistema de sessão)
$user_role = 'admin'; 
$username = 'Admin'; 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NETNÚCLEO - <?php echo htmlspecialchars($pageTitle); ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <style>
        /* Cores e Fontes Base */
        :root {
            --senai-blue: #003366;
            --senai-dark-blue: #2a3c50;
            --senai-red: #D71920; 
            --light-gray: #f2f2f2;
            --medium-gray: #e9ecef;
            --dark-gray: #6c757d;
            --white: #ffffff;
            --font-family: 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: var(--light-gray);
            font-family: var(--font-family);
            color: #333;
            margin: 0;
        }
        .header-bar {
            background-color: var(--senai-blue);
            height: 10px;
        }
        .navbar {
            background-color: var(--white);
            border-bottom: 2px solid #ccc;
            padding: 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .navbar .container-fluid {
            padding: 10px 20px;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }
        .logo-senai {
            height: 60px;
            margin-right: 15px;
        }
        .header-text {
            font-size: 24px;
            font-weight: bold;
            color: var(--senai-blue);
            text-align: center;
            position: absolute;
            left: 50%;
            transform: translateX(-50%) translateY(-50%);
            top: 50%;
            pointer-events: none;
            z-index: 1;
            white-space: nowrap;
        }
        .navbar-text {
            font-size: 1rem;
            color: var(--dark-gray);
            display: flex;
            align-items: center;
        }
        .navbar-text .btn-outline-secondary {
            margin-left: 10px;
            padding: 0.375rem 0.75rem;
            font-size: 0.9rem;
        }
        .btn-outline-primary {
            border-color: var(--senai-blue);
            color: var(--senai-blue);
        }
        .btn-outline-primary:hover {
            background-color: var(--senai-blue);
            color: var(--white);
        }

        .highlight-bar {
            background-color: #ff6600;
            height: 5px;
            width: 100%;
        }

        .container.mt-4 {
            background-color: var(--white);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        h1 {
            color: var(--senai-blue);
            font-size: 2rem;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 600;
        }
        h2, h3, h4 {
            color: var(--senai-blue);
            margin-bottom: 20px;
            font-weight: 600;
        }

        .card.p-4 {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            border-radius: 8px;
            padding: 25px !important;
            margin-bottom: 30px;
        }
        .form-label {
            font-weight: 500;
            color: var(--senai-blue);
            margin-bottom: 5px;
        }
        .form-control, .form-select {
            border-radius: 5px;
            border: 1px solid #ced4da;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            margin-bottom: 15px;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--senai-blue);
            box-shadow: 0 0 0 0.25rem rgba(0, 51, 102, 0.25);
        }
        .btn-primary {
            background-color: var(--senai-blue);
            border-color: var(--senai-blue);
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            border-radius: 5px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #002244;
            border-color: #002244;
        }
        .btn-secondary {
            background-color: var(--dark-gray);
            border-color: var(--dark-gray);
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            border-radius: 5px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
        }

        .table-responsive {
            margin-top: 30px;
        }
        .table-bordered {
            border-color: #e0e0e0;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #e0e0e0;
            vertical-align: middle;
            padding: 12px;
            font-size: 0.9rem;
        }
        .table-bordered thead th {
            background-color: var(--medium-gray);
            color: var(--senai-blue);
            font-weight: 600;
            text-align: center;
        }
        .table-bordered tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .table-bordered tbody tr:hover {
            background-color: #f0f0f0;
        }
        .table-bordered tbody td {
            text-align: center;
        }
        .table-bordered tbody td:empty:before {
            content: '-';
            color: var(--dark-gray);
        }

        .btn-sm-custom-wide {
            padding: 0.5rem 1.8rem;
            font-size: 0.85rem;
            line-height: 1.5;
            min-width: 120px;
        }
        .btn-sm-custom {
            padding: 0.3rem 0.8rem;
            font-size: 0.8rem;
            line-height: 1.2;
            border-radius: 4px;
            margin: 2px;
        }
        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
            color: var(--white);
        }
        .btn-info:hover {
            background-color: #138496;
            border-color: #138496;
        }
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #212529;
        }
        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #e0a800;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: var(--white);
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #c82333;
        }

        #loadingMessage, #errorMessage {
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 1.1rem;
            font-weight: 500;
        }
        #loadingMessage {
            background-color: #e0f7fa;
            color: #007bb6;
            border: 1px solid #b2ebf2;
        }
        #errorMessage {
            background-color: #ffebee;
            color: #d32f2f;
            border: 1px solid #ef9a9a;
        }
        .spinner-border {
            width: 1.5rem;
            height: 1.5rem;
            margin-bottom: 10px;
        }

        .modal-content {
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
        .modal-header {
            background-color: var(--senai-blue);
            color: var(--white);
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            padding: 15px 20px;
            border-bottom: none;
        }
        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
        }
        .modal-header .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
        .modal-body {
            padding: 25px;
        }
        .modal-body p {
            margin-bottom: 8px;
            font-size: 0.95rem;
        }
        .modal-body strong {
            color: var(--senai-blue);
        }
        .modal-body hr {
            margin-top: 20px;
            margin-bottom: 20px;
            border-top: 1px solid #eee;
        }
        .modal-body h6 {
            color: var(--senai-blue);
            font-size: 1.1rem;
            margin-bottom: 15px;
        }
        .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 15px 20px;
        }
    </style>
</head>
<body>
    <div class="header-bar"></div>

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="img/logo-senai.png" alt="SENAI Logo" class="logo-senai">
            </a>
            <span class="header-text">NETNÚCLEO - HORTO</span>
            
            <div class="navbar-text">
                Olá, <?php echo htmlspecialchars($username); ?>! 
                <a class="btn btn-outline-secondary" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="highlight-bar"></div>

    <div class="container mt-4">
        <?php
        // Exibe mensagens de feedback da sessão (ADICIONADO)
        if (isset($_SESSION['message'])) {
            $alertClass = ($_SESSION['message_type'] == "success") ? "alert-success" : "alert-danger";
            echo '<div class="alert ' . $alertClass . ' alert-dismissible fade show" role="alert">';
            echo htmlspecialchars($_SESSION['message']);
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo '</div>';
            unset($_SESSION['message']); // Limpa a mensagem da sessão para que não apareça novamente
            unset($_SESSION['message_type']); // Limpa o tipo da mensagem
        }
        ?>
        <div class="card p-4">
            <h1 class="text-center mb-4">Cadastro de Nova Aula</h1>

            <form id="cadastroAulaForm" method="POST" action="processa_cadastro_aula.php">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="dataAula" class="form-label">Data da Aula:</label>
                        <input type="date" class="form-control" id="dataAula" name="dataAula" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="periodoAula" class="form-label">Período:</label>
                        <select class="form-select" id="periodoAula" name="periodoAula" required>
                            <option value="" disabled selected>Selecione o Período</option>
                            <option value="Manhã">Manhã</option>
                            <option value="Tarde">Tarde</option>
                            <option value="Noite">Noite</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="instrutor" class="form-label">Instrutor:</label>
                        <select class="form-select" id="instrutor" name="instrutor" required>
                            <option value="" disabled selected>Selecione um Instrutor</option>
                            <?php 
                            // Loop para preencher os instrutores
                            foreach ($instrutores as $instrutor) {
                                echo '<option value="' . htmlspecialchars($instrutor['id']) . '">' . htmlspecialchars($instrutor['nome']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="sala" class="form-label">Sala:</label>
                        <select class="form-select" id="sala" name="sala" required>
                            <option value="" disabled selected>Selecione a Sala</option>
                            <?php 
                            // Loop para preencher as salas
                            foreach ($salas as $sala) {
                                echo '<option value="' . htmlspecialchars($sala['id']) . '">' . htmlspecialchars($sala['nome']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="materia" class="form-label">Matéria:</label>
                        <select class="form-select" id="materia" name="materia" required>
                            <option value="" disabled selected>Selecione a Matéria</option>
                            <?php 
                            foreach ($materias as $materia) {
                                echo '<option value="' . htmlspecialchars($materia['id']) . '">' . htmlspecialchars($materia['nome']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="turma" class="form-label">Turma:</label>
                        <select class="form-select" id="turma" name="turma" required>
                            <option value="" disabled selected>Selecione a Turma</option>
                            <?php 
                            foreach ($turmas as $turma) {
                                echo '<option value="' . htmlspecialchars($turma['id']) . '">' . htmlspecialchars($turma['nome']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="tipoAula" class="form-label">Tipo de Aula:</label>
                    <select class="form-select" id="tipoAula" name="tipoAula" required>
                        <option value="" disabled selected>Selecione o Tipo</option>
                        <option value="Presencial">Presencial</option>
                        <option value="Online">Online</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="observacoes" class="form-label">Observações (Opcional):</label>
                    <textarea class="form-control" id="observacoes" name="observacoes" rows="3"></textarea>
                </div>

                <div class="d-flex justify-content-center gap-3 mt-4">
                    <button type="submit" class="btn btn-primary">Cadastrar Aula</button>
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Voltar ao Menu</button>
                </div>
                
                <div id="alertMessage" class="alert mt-3 d-none" role="alert"></div>

            </form>

            <h2 class="mt-5 text-center">Aulas Cadastradas Recentemente</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Data</th>
                            <th>Período</th>
                            <th>Instrutor</th>
                            <th>Sala</th>
                            <th>Tipo</th>
                            <th>Observações</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="8" class="text-center">Nenhuma aula cadastrada recentemente.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('cadastroAulaForm');
            form.addEventListener('submit', function(event) {
                // Lógica de validação front-end aqui, se desejar
            });
        });
    </script>

</body>
</html>

<?php
// Fecha a conexão com o banco de dados no final da página
if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}
?>