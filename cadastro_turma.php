<?php
// Inclui o script de verificação de sessão e carrega as variáveis de usuário
include 'php/_check_session.php'; 

// Variáveis para exibir no cabeçalho
$id_usuario_logado = $_SESSION['id_usuario'] ?? null;
$nome_usuario_logado = $_SESSION['username'] ?? 'Usuário Desconhecido'; 
$user_role = $_SESSION['user_role'] ?? 'visitante'; // Role do usuário logado
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NETNÚCLEO - Consulta de Sala</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* Cores e Fontes Base (MANTIDAS) */
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
        .btn-outline-primary {
            border-color: var(--senai-blue);
            color: var(--senai-blue);
        }
        .btn-outline-primary:hover {
            background-color: var(--senai-blue);
            color: var(--white);
        }

        .container.mt-4 {
            background-color: var(--white);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        h1 {
            color: var(--senai-blue);
            font-size: 2rem;
            margin-bottom: 25px;
            text-align: center;
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
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
        }

        h4 {
            color: var(--senai-blue);
            font-size: 1.5rem;
            margin-bottom: 20px;
            border-bottom: 2px solid var(--medium-gray);
            padding-bottom: 10px;
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
        .table-bordered tbody td:nth-child(1),
        .table-bordered tbody td:nth-child(2),
        .table-bordered tbody td:nth-child(3) {
            white-space: nowrap;
        }
        .table-bordered tbody td:nth-child(4) {
             white-space: nowrap; 
        }

        .aula-content {
            font-size: 0.85em;
            line-height: 1.4;
            padding: 5px;
        }
        .aula-content strong {
            display: block;
            font-size: 0.95em;
            color: var(--senai-blue);
            margin-bottom: 3px;
        }
        .table-bordered tbody td:empty:before {
            content: '-';
            color: var(--dark-gray);
        }

        /* Botão de Edição de Sala */
        .btn-edit-sala { /* Novo estilo para botão de edição de sala */
            padding: 0.2rem 0.6rem;
            font-size: 0.75rem;
            line-height: 1.2;
            border-radius: 4px;
            margin-top: 8px;
            background-color: #007bff; /* Cor diferente para diferenciar */
            border-color: #007bff;
            color: var(--white);
        }
        .btn-edit-sala:hover {
            background-color: #0056b3;
            border-color: #0056b3;
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

        /* Modal para Edição da Sala da Aula */
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
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center"> <li class="nav-item me-3"> <a class="nav-link" href="perfil.php" title="Meu Perfil"> <i class="bi bi-person-circle" style="font-size: 1.5rem; color: var(--senai-blue);"></i> </a>
                </li>
                <li class="nav-item">
                    <span class="navbar-text me-3">Olá, <?php echo htmlspecialchars($nome_usuario_logado); ?>!</span>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-primary" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
    <div class="container mt-4">
        <h1>Cadastro de Nova Turma</h1>

        <form id="cadastroTurmaForm">
            <div class="mb-3">
                <label for="nomeTurma" class="form-label">Nome da Turma:</label>
                <input type="text" class="form-control" id="nomeTurma" name="nome_turma" required>
            </div>

            <div class="mb-3">
                <label for="curso" class="form-label">Curso:</label>
                <div class="input-group">
                    <select class="form-select" id="curso" name="id_curso" required>
                        <option value="">Selecione um curso</option>
                        </select>
                    <button class="btn btn-outline-secondary" type="button" id="addCursoBtn" data-bs-toggle="modal" data-bs-target="#addCursoModal">
                        + Novo Curso
                    </button>
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="dataInicioCurso" class="form-label">Data de Início do Curso:</label>
                    <input type="date" class="form-control" id="dataInicioCurso" name="data_inicio_curso" required>
                </div>
                <div class="col-md-6">
                    <label for="dataTerminoCurso" class="form-label">Data de Término do Curso:</label>
                    <input type="date" class="form-control" id="dataTerminoCurso" name="data_termino_curso" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="statusTurma" class="form-label">Status da Turma:</label>
                <select class="form-select" id="statusTurma" name="status_turma" required>
                    <option value="Ativa">Ativa</option>
                    <option value="Encerrada">Encerrada</option>
                </select>
            </div>
            
            <div id="alertMessage" class="alert" style="display: none;"></div>

           <div class="d-flex justify-content-center gap-3 mt-4">
    <button type="submit" class="btn btn-primary">Cadastrar Turma</button>
    <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Voltar ao Menu</button>
</div>
        </form>

        <h3 class="mt-5 text-center text-primary">Turmas Cadastradas Recentemente</h3>
        <div id="recentTurmasTableContainer" class="table-responsive">
            <table class="table table-bordered table-striped mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome da Turma</th>
                        <th>Curso</th>
                        <th>Status</th>
                        <th>Início</th>
                        <th>Término</th>
                    </tr>
                </thead>
                <tbody id="recentTurmasTableBody">
                    <tr><td colspan="6" class="text-center">Nenhuma turma cadastrada recentemente.</td></tr>
                </tbody>
            </table>
        </div>
        

    </div>

    <div class="modal fade" id="addCursoModal" tabindex="-1" aria-labelledby="addCursoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCursoModalLabel">Adicionar Novo Curso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addCursoForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nomeNovoCurso" class="form-label">Nome do Novo Curso:</label>
                            <input type="text" class="form-control" id="nomeNovoCurso" name="nome_curso" required>
                        </div>
                        <div id="addCursoAlert" class="alert" style="display: none;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar Curso</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cadastroTurmaForm = document.getElementById('cadastroTurmaForm');
            const cursoSelect = document.getElementById('curso');
            const dataInicioCursoInput = document.getElementById('dataInicioCurso');
            const dataTerminoCursoInput = document.getElementById('dataTerminoCurso');
            const alertMessageDiv = document.getElementById('alertMessage');
            const recentTurmasTableBody = document.getElementById('recentTurmasTableBody');

            // Modal para adicionar curso
            const addCursoModal = new bootstrap.Modal(document.getElementById('addCursoModal'));
            const addCursoForm = document.getElementById('addCursoForm');
            const addCursoAlertDiv = document.getElementById('addCursoAlert');

            // --- Funções Auxiliares ---
            function showAlert(message, type) {
                alertMessageDiv.textContent = message;
                alertMessageDiv.className = `alert alert-${type}`;
                alertMessageDiv.style.display = 'block';
                setTimeout(() => {
                    alertMessageDiv.style.display = 'none';
                }, 5000);
            }

            function showAddCursoAlert(message, type) {
                addCursoAlertDiv.textContent = message;
                addCursoAlertDiv.className = `alert alert-${type}`;
                addCursoAlertDiv.style.display = 'block';
                setTimeout(() => {
                    addCursoAlertDiv.style.display = 'none';
                }, 5000);
            }

            // Popula o dropdown de Cursos
            async function populateCursosDropdown(selectedId = null) {
                try {
                    const response = await fetch('php/get_cursos.php');
                    if (!response.ok) {
                        throw new Error(`Erro HTTP: ${response.status}`);
                    }
                    const data = await response.json();
                    
                    cursoSelect.innerHTML = '<option value="">Selecione um curso</option>';
                    if (data.success && data.cursos.length > 0) {
                        data.cursos.forEach(curso => {
                            const option = document.createElement('option');
                            option.value = curso.id_curso;
                            option.textContent = curso.nome_curso;
                            cursoSelect.appendChild(option);
                        });
                        if (selectedId) {
                            cursoSelect.value = selectedId;
                        }
                    }
                } catch (error) {
                    console.error('Erro ao carregar cursos:', error);
                    showAlert('Erro ao carregar a lista de cursos.', 'danger');
                }
            }

            // Função para buscar e exibir turmas recentes
            async function fetchRecentTurmas() {
                try {
                    const response = await fetch('php/get_recent_turmas.php');
                    if (!response.ok) {
                        throw new Error(`Erro HTTP: ${response.status}`);
                    }
                    const data = await response.json();

                    recentTurmasTableBody.innerHTML = ''; // Limpa a tabela

                    if (data.success && data.turmas.length > 0) {
                        data.turmas.forEach(turma => {
                            const row = recentTurmasTableBody.insertRow();
                            row.insertCell().textContent = turma.id_turma;
                            row.insertCell().textContent = turma.nome_turma;
                            row.insertCell().textContent = turma.nome_curso || 'N/A';
                            row.insertCell().textContent = turma.status_turma;
                            row.insertCell().textContent = turma.data_inicio_formatada || '-';
                            row.insertCell().textContent = turma.data_termino_formatada || '-';
                        });
                    } else {
                        recentTurmasTableBody.innerHTML = '<tr><td colspan="6" class="text-center">Nenhuma turma cadastrada recentemente.</td></tr>';
                    }
                } catch (error) {
                    console.error('Erro ao buscar turmas recentes:', error);
                    recentTurmasTableBody.innerHTML = '<tr><td colspan="6" class="text-center text-danger">Erro ao carregar turmas.</td></tr>';
                }
            }


            // --- Event Listeners ---

            // Envio do formulário de Cadastro de Turma
            cadastroTurmaForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                // Certifique-se de que os campos de data estão formatados corretamente
                formData.set('data_inicio_curso', dataInicioCursoInput.value);
                formData.set('data_termino_curso', dataTerminoCursoInput.value);

                try {
                    const response = await fetch('php/processa_cadastro_turma.php', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (result.success) {
                        showAlert('Turma cadastrada com sucesso!', 'success');
                        cadastroTurmaForm.reset(); // Limpa o formulário
                        populateCursosDropdown(); // Recarrega cursos para limpar seleção se necessário
                        fetchRecentTurmas(); // Atualiza a lista de turmas recentes
                    } else {
                        showAlert('Erro ao cadastrar turma: ' + result.message, 'danger');
                    }
                } catch (error) {
                    console.error('Erro ao enviar formulário de turma:', error);
                    showAlert('Ocorreu um erro inesperado ao cadastrar a turma.', 'danger');
                }
            });

            // Envio do formulário de Adicionar Novo Curso (dentro do modal)
            addCursoForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                try {
                    const response = await fetch('php/add_curso.php', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (result.success) {
                        showAddCursoAlert('Curso adicionado com sucesso!', 'success');
                        addCursoForm.reset(); // Limpa o formulário do modal
                        addCursoModal.hide(); // Fecha o modal
                        await populateCursosDropdown(result.id_curso); // Recarrega o dropdown de cursos e seleciona o novo curso
                    } else {
                        showAddCursoAlert('Erro ao adicionar curso: ' + result.message, 'danger');
                    }
                } catch (error) {
                    console.error('Erro ao enviar formulário de adicionar curso:', error);
                    showAddCursoAlert('Ocorreu um erro inesperado ao adicionar o curso.', 'danger');
                }
            });


            // --- Inicialização ---
            populateCursosDropdown(); // Carrega os cursos quando a página é carregada
            fetchRecentTurmas(); // Carrega as turmas recentes ao carregar a página
        });
    </script>
</body>
</html>