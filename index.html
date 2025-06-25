<?php
// Inclui o script de verificação de sessão.
// Certifique-se de que este caminho está correto para o seu arquivo _check_session.php
include 'php/_check_session.php'; 

// As variáveis de sessão já estão disponíveis por causa do _check_session.php
$username = $_SESSION['username'];
$user_role = $_SESSION['user_role'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NETNÚCLEO - Menu Principal</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css"> 
    <style>
        /* Estilos específicos para o layout do index.php */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f2f2f2; /* Cor de fundo padrão */
        }
        .header-bar {
            background-color:#003366; /* Cor da barra escura acima do menu */
            height: 10px;
        }
        .navbar {
            background-color: #ffffff; /* Fundo branco do navbar */
            border-bottom: 2px solid #ccc;
            padding: 0; /* Remove padding padrão para controlar com o conteúdo */
        }
        .navbar .container-fluid {
            padding: 10px 20px; /* Padding interno do container do navbar */
            align-items: center;
            justify-content: flex-start; /* Alinha o conteúdo à esquerda */
            position: relative; /* Para posicionar o título centralizado */
        }
        .logo-senai {
            height: 60px; /* Ajuste conforme a imagem */
            margin-right: 15px; /* Espaçamento entre logo e texto */
        }
        .header-text {
            font-size: 24px;
            font-weight: bold;
            color: #003366; /* Cor do texto "NETNÚCLEO - HORTO" */
            flex-grow: 1; /* Permite que o texto ocupe o espaço restante */
            text-align: center; /* Centraliza o texto */
            position: absolute; /* Posiciona o título de forma absoluta */
            left: 0;
            right: 0;
            top: 50%; /* Centraliza verticalmente */
            transform: translateY(-50%); /* Ajuste fino para o centro vertical */
            pointer-events: none; /* Ignora eventos de clique para não bloquear a logo */
        }
        .main-content {
            flex: 1; /* Faz o conteúdo principal ocupar o espaço restante */
            padding: 20px;
            margin-top: 10px; /* Espaçamento após o navbar */
        }
        .sidebar {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px; /* Espaço abaixo da sidebar em telas pequenas */
        }
        .content-area {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        /* Estilos para os botões do menu lateral */
        .sidebar .btn {
            margin-bottom: 10px; /* Espaço entre os botões */
            width: 100%; /* Faz os botões ocuparem toda a largura */
            text-align: left; /* Alinha o texto do botão à esquerda */
        }
        .sidebar h3, .sidebar h4 {
            color: #003366;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
    </style>
</head>
<body>

    <div class="header-bar"></div>

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="img/logo-senai.png" alt="SENAI Logo" class="logo-senai">
            </a>
            <span class="header-text">NETNÚCLEO - HORTO</span>
            <div class="ms-auto d-flex align-items-center">
                <span class="navbar-text me-3">Olá, <?php echo htmlspecialchars($username); ?>!</span>
                <a class="btn btn-outline-primary" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid main-content">
        <div class="row">
            <div class="col-md-3 sidebar">
                <h3>Acesse em dispositivos móveis através dos botões:</h3>
                <div class="d-grid gap-2">
                    <a class="btn btn-primary" href="consulta_aula.php">Consulta Aula</a>
                    <a class="btn btn-primary" href="consulta_instrutor.php">Consulta Instrutor</a>
                    <a class="btn btn-primary" href="consulta_sala.php">Consulta Sala</a>
                </div>

                <?php if ($user_role === 'admin'): ?>
                    <hr>
                    <h4>Opções de Administrador:</h4>
                    <div class="d-grid gap-2">
                        <a class="btn btn-secondary" href="cadastro_turma.php">Cadastrar Turma</a>
                        <a class="btn btn-secondary" href="cadastro_aula.php">Cadastrar Aula</a>
                        </div>
                <?php endif; ?>

                <?php if ($user_role === 'aluno'): ?>
                    <hr>
                    <h4>Opções de Aluno:</h4>
                    <div class="d-grid gap-2">
                        <a class="btn btn-secondary" href="meus_horarios.php">Meus Horários</a>
                        </div>
                <?php endif; ?>
            </div>

            <div class="col-md-9 content-area">
                <h1>Bem-vindo ao NETNÚCLEO - HORTO!</h1>
                <p>Olá, <?php echo htmlspecialchars($username); ?>!</p>
                <p>Seu perfil é: <?php echo htmlspecialchars($user_role); ?>.</p>
                <p>Use o menu lateral para acessar as opções de consulta.</p>
                
                <?php if ($user_role === 'admin'): ?>
                    <p>Para administradores, o menu superior oferece opções de cadastro e movimentação.</p>
                <?php endif; ?>

                </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>