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
    <title>NETNÚCLEO - Consulta de Aulas</title>
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

        /* Container Principal */
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

        /* Card de Filtros */
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

        /* Tabela de Resultados */
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
        .table-bordered tbody td:empty:before {
            content: '-';
            color: var(--dark-gray);
        }

        /* Botões de Ação na Tabela */
        .btn-sm-custom {
            padding: 0.2rem 0.6rem;
            font-size: 0.75rem;
            line-height: 1.2;
            border-radius: 4px;
            margin: 2px; /* Pequena margem para separar botões */
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
            color: #212529; /* Cor do texto para contraste */
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

        /* Mensagens de Carregamento/Erro */
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

        /* Modal de Edição (Estilo genérico, será adaptado para o conteúdo específico) */
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
          /* Adicione estas novas classes ao seu bloco <style> */
    .btn-sm-custom-wide {
        padding: 0.5rem 1.8rem; /* Ajusta o padding para deixá-lo mais largo e menor na altura */
        font-size: 0.85rem;   /* Tamanho da fonte menor */
        line-height: 1.5;     /* Altura da linha para ajuste do texto */
        min-width: 120px;     /* Largura mínima para garantir que fiquem mais largos */
    }

    /* Ajuste para os botões existentes que também podem se beneficiar de serem um pouco menores */
    .btn-sm-custom {
        padding: 0.3rem 0.8rem; /* Originalmente 0.2rem 0.6rem, aumentei um pouco */
        font-size: 0.8rem;    /* Levemente maior que 0.75rem */
        line-height: 1.2;
        border-radius: 4px;
        margin: 2px;
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
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
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
        <h1>Consulta e Gestão de Aulas</h1>

        <div class="card p-4">
            <form id="filterForm">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="dataInicial" class="form-label">Data Inicial:</label>
                        <input type="date" class="form-control" id="dataInicial" name="dataInicial">
                    </div>
                    <div class="col-md-4">
                        <label for="dataFinal" class="form-label">Data Final:</label>
                        <input type="date" class="form-control" id="dataFinal" name="dataFinal">
                    </div>
                    <div class="col-md-4">
                        <label for="periodo" class="form-label">Período:</label>
                        <select class="form-select" id="periodo" name="periodo">
                            <option value="">Todos</option>
                            <option value="Manhã">Manhã</option>
                            <option value="Tarde">Tarde</option>
                            <option value="Noite">Noite</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="instrutor" class="form-label">Instrutor:</label>
                        <select class="form-select" id="instrutor" name="instrutor">
                            <option value="">Todos</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="sala" class="form-label">Sala:</label>
                        <select class="form-select" id="sala" name="sala">
                            <option value="">Todas</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end justify-content-end">
                        <div class="form-check form-check-inline mb-3">
                            <input class="form-check-input" type="checkbox" id="mostrarEncerradas" name="mostrarEncerradas" value="true">
                            <label class="form-check-label" for="mostrarEncerradas">Mostrar Aulas Encerradas</label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm-custom-wide me-2">Filtrar Aulas</button>
                        <button type="button" class="btn btn-secondary btn-sm-custom-wide" onclick="window.location.href='index.php'">Voltar ao Menu</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="mt-4 table-responsive">
            <h4>Aulas Encontradas</h4>
            <div id="loadingMessage" class="text-center" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Carregando...</span>
                </div>
                <p>Carregando dados das aulas...</p>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Dia Semana</th>
                        <th>Período</th>
                        <th>Instrutor</th>
                        <th>Sala</th>
                        <th>Curso</th> <th>Tipo</th>
                        <th>Status</th>
                        <th>Observações</th>
                        <?php 
                        // Ajusta o colspan da célula "Nenhum dado para exibir" no <tbody>
                        // Originalmente era 10 (ou 9 sem ações). Agora com "Curso", é 11 (ou 10 sem ações).
                        $colspan_base = 10; // ID, Data, Dia, Período, Instrutor, Sala, Curso, Tipo, Status, Observações
                        if ($user_role === 'admin' || $user_role === 'coordenador') {
                            echo '<th>Ações</th>';
                            $colspan_base++; // Adiciona 1 para a coluna "Ações"
                        }
                        ?>
                    </tr>
                </thead>
                <tbody id="aulasTableBody">
                    <tr>
                        <td colspan="<?php echo $colspan_base; ?>" class="text-center">Nenhum dado para exibir. Utilize os filtros acima.</td>
                    </tr>
                </tbody>
            </table>
            <div id="errorMessage" class="alert alert-danger mt-3" style="display: none;"></div>
        </div>
    </div>

    <div class="modal fade" id="editAulaModal" tabindex="-1" aria-labelledby="editAulaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAulaModalLabel">Detalhes e Edição da Aula</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editAulaForm">
                    <div class="modal-body">
                        <input type="hidden" id="edit_id_aula" name="id_aula">
                        <p><strong>ID da Aula:</strong> <span id="display_aula_id"></span></p>
                        <p><strong>Data:</strong> <span id="display_data_aula"></span></p>
                        <p><strong>Dia da Semana:</strong> <span id="display_dia_aula"></span></p>
                        <p><strong>Período:</strong> <span id="display_periodo_aula"></span></p>
                        <p><strong>Instrutor:</strong> <span id="display_instrutor_nome"></span></p>
                        <p><strong>Sala:</strong> <span id="display_sala"></span></p>
                        <p><strong>Curso:</strong> <span id="display_curso_nome"></span></p> <p><strong>Tipo:</strong> <span id="display_tipo_aula"></span></p>
                        <p><strong>Status:</strong> <span id="display_status_aula"></span></p> <hr>
                        <h6>Atualizar Informações da Aula:</h6>
                        <div class="mb-3">
                            <label for="edit_instrutor" class="form-label">Trocar Instrutor (Opcional):</label>
                            <select class="form-select" id="edit_instrutor" name="novo_id_instrutor">
                                <option value="">- Manter instrutor atual -</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_sala" class="form-label">Trocar Sala (Opcional):</label>
                            <select class="form-select" id="edit_sala" name="nova_id_sala">
                                <option value="">- Manter sala atual -</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_motivo_falta" class="form-label">Observações da Aula (Opcional):</label>
                            <textarea class="form-control" id="edit_motivo_falta" name="motivo_falta" rows="3" placeholder="Ex: Sala indisponível, aula cancelada, etc."></textarea>
                            <small class="form-text text-muted">Este campo pode ser usado para registrar o motivo de ausência ou outras observações.</small>
                        </div>
                        <div class="mb-3">
                            <label for="edit_status" class="form-label">Alterar Status:</label>
                            <select class="form-select" id="edit_status" name="novo_status_aula">
                                <option value="Agendada">Agendada</option>
                                <option value="Em Andamento">Em Andamento</option>
                                <option value="Realizada">Realizada</option>
                                <option value="Cancelada">Cancelada</option>
                                <option value="Encerrada">Encerrada</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        console.log("Script consulta_aula.php versão: 2025-06-12 15:00 - Adicionado Status, 2025-06-23 14:18 - Adicionado Curso");

        document.addEventListener('DOMContentLoaded', async function() {
            const filterForm = document.getElementById('filterForm');
            const aulasTableBody = document.getElementById('aulasTableBody');
            const errorMessageDiv = document.getElementById('errorMessage');
            const loadingMessageDiv = document.getElementById('loadingMessage');
            
            const dataInicialInput = document.getElementById('dataInicial');
            const dataFinalInput = document.getElementById('dataFinal');
            const periodoSelect = document.getElementById('periodo');
            const instrutorSelect = document.getElementById('instrutor');
            const salaSelect = document.getElementById('sala');
            const mostrarEncerradasCheckbox = document.getElementById('mostrarEncerradas');

            const userRole = '<?php echo $user_role; ?>'; // PHP variable for JS

            // Modal de edição e seus elementos
            const editAulaModal = new bootstrap.Modal(document.getElementById('editAulaModal'));
            const editAulaForm = document.getElementById('editAulaForm');
            const editInstrutorSelect = document.getElementById('edit_instrutor');
            const editSalaSelect = document.getElementById('edit_sala');
            const editStatusSelect = document.getElementById('edit_status'); // Elemento select para o status no modal


            // Preenche as datas com o dia atual se estiverem vazias
            const today = new Date();
            const year = today.getFullYear();
            const month = (today.getMonth() + 1).toString().padStart(2, '0');
            const day = today.getDate().toString().padStart(2, '0');
            const formattedDate = `${year}-${month}-${day}`;
            
            if (!dataInicialInput.value) { 
                dataInicialInput.value = formattedDate;
            }
            if (!dataFinalInput.value) { 
                dataFinalInput.value = formattedDate;
            }

            // Funções de utilidade
            function showErrorMessage(message) {
                errorMessageDiv.textContent = message;
                errorMessageDiv.style.display = 'block';
                setTimeout(() => errorMessageDiv.style.display = 'none', 7000);
            }

            // Funções para popular os dropdowns de filtro
            async function populateDropdown(selectElement, type, selectedId = null) {
                try {
                    const response = await fetch(`php/get_filters.php?get=${type}_all`);
                    if (!response.ok) {
                        throw new Error(`Erro HTTP: ${response.status} ${response.statusText}`);
                    }
                    const data = await response.json();
                    
                    let defaultOptionText = '';
                    switch (type) {
                        case 'instrutores': defaultOptionText = 'Todos'; break;
                        case 'salas': defaultOptionText = 'Todas'; break;
                        case 'status': defaultOptionText = '- Manter status atual -'; break; 
                        default: defaultOptionText = '- Selecione -';
                    }
                    selectElement.innerHTML = `<option value="">${defaultOptionText}</option>`; 

                    const key = type; 
                    if (data[key]) {
                        data[key].forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.id; // Para instrutor/sala
                            option.textContent = item.nome; // Para instrutor/sala
                            if (type === 'status') { // Tratamento específico para o dropdown de status
                                option.value = item.status;
                                option.textContent = item.status;
                            }
                            selectElement.appendChild(option);
                        });
                    }
                    if (selectedId) {
                        selectElement.value = selectedId;
                    }

                } catch (error) {
                    console.error(`Erro ao popular ${type}:`, error);
                    showErrorMessage(`Erro ao carregar opções de ${type}. Tente novamente.`);
                }
            }


            // Função principal para buscar e exibir aulas
            async function fetchAulas(event) {
                if (event) event.preventDefault();

                const formData = new FormData(filterForm);
                const queryParams = new URLSearchParams(formData).toString(); // Isso transforma em string para a URL

                aulasTableBody.innerHTML = ''; // Limpa a tabela
                errorMessageDiv.style.display = 'none';
                loadingMessageDiv.style.display = 'block';

                try {
                    const response = await fetch(`php/get_aulas.php?${queryParams}`);
                    if (!response.ok) {
                        throw new Error(`Erro HTTP: ${response.status} ${response.statusText}`);
                    }
                    const data = await response.json();

                    if (data.success && data.aulas.length > 0) {
                        data.aulas.forEach(aula => {
                            const row = aulasTableBody.insertRow();
                            row.insertCell().textContent = aula.id_aula;
                            row.insertCell().textContent = aula.data_aula_formatada;
                            row.insertCell().textContent = aula.dia_semana_pt;
                            row.insertCell().textContent = aula.periodo_aula;
                            row.insertCell().textContent = aula.nome_instrutor || 'N/A'; // N/A se null
                            row.insertCell().textContent = aula.nome_sala;
                            row.insertCell().textContent = aula.nome_curso || 'N/A'; // ADICIONADO: Exibe o nome do curso
                            row.insertCell().textContent = aula.tipo_aula;
                            row.insertCell().textContent = aula.status_turma; 
                            row.insertCell().textContent = aula.motivo_falta || '-'; // Exibe '-' se null

                            // Coluna Ações (apenas para admin/coordenador)
                            if (userRole === 'admin' || userRole === 'coordenador') {
                                const actionsCell = row.insertCell();
                                const editBtn = document.createElement('button');
                                editBtn.className = 'btn btn-info btn-sm-custom me-1';
                                editBtn.textContent = 'Editar';
                                editBtn.setAttribute('data-id-aula', aula.id_aula);
                                editBtn.setAttribute('data-data-aula', aula.data_aula_formatada);
                                editBtn.setAttribute('data-dia-aula', aula.dia_semana_pt);
                                editBtn.setAttribute('data-periodo-aula', aula.periodo_aula);
                                editBtn.setAttribute('data-instrutor', aula.nome_instrutor); // Para exibição no modal
                                editBtn.setAttribute('data-id-instrutor', aula.id_instrutor); // Para seleção no dropdown do modal
                                editBtn.setAttribute('data-sala', aula.nome_sala);
                                editBtn.setAttribute('data-id-sala', aula.id_sala);
                                editBtn.setAttribute('data-curso-nome', aula.nome_curso); // NOVO: Passa o nome do curso para o modal
                                editBtn.setAttribute('data-tipo-aula', aula.tipo_aula);
                                editBtn.setAttribute('data-motivo-falta', aula.motivo_falta || '');
                                editBtn.setAttribute('data-status-aula', aula.status_turma); 

                                editBtn.addEventListener('click', openEditModal);
                                actionsCell.appendChild(editBtn);

                                // Botão de Excluir (opcional, pode ser adicionado se necessário)
                                // const deleteBtn = document.createElement('button');
                                // deleteBtn.className = 'btn btn-danger btn-sm-custom';
                                // deleteBtn.textContent = 'Excluir';
                                // deleteBtn.setAttribute('data-id-aula', aula.id_aula);
                                // deleteBtn.addEventListener('click', deleteAula);
                                // actionsCell.appendChild(deleteBtn);
                            }
                        });
                    } else {
                        // O colspan deve ser ajustado para 10 se o status for sempre visível, e 9 se for invisível para visitantes.
                        // O '10' é para admin/coordenador que verão ações e status. O '9' para visitantes que verão apenas status.
                        // Atualizado para 11 (com ações) ou 10 (sem ações), devido à inclusão da coluna 'Curso'.
                        const colspanValue = (userRole === 'admin' || userRole === 'coordenador') ? '11' : '10';
                        aulasTableBody.innerHTML = `<tr><td colspan="${colspanValue}" class="text-center">${data.message || 'Nenhum dado encontrado para os filtros aplicados.'}</td></tr>`;
                    }
                } catch (error) {
                    console.error('Erro ao buscar aulas:', error);
                    const colspanValue = (userRole === 'admin' || userRole === 'coordenador') ? '11' : '10'; // Ajustado também aqui
                    aulasTableBody.innerHTML = `<tr><td colspan="${colspanValue}" class="text-center">Ocorreu um erro ao buscar os dados.</td></tr>`;
                    showErrorMessage('Ocorreu um erro inesperado ao carregar as aulas. Tente novamente.');
                } finally {
                    loadingMessageDiv.style.display = 'none';
                }
            }

            // Função para abrir e preencher o modal de edição
            async function openEditModal() {
                const aulaId = this.getAttribute('data-id-aula');
                const dataAula = this.getAttribute('data-data-aula');
                const diaAula = this.getAttribute('data-dia-aula');
                const periodoAula = this.getAttribute('data-periodo-aula');
                const instrutorNome = this.getAttribute('data-instrutor'); // Nome para exibição
                const idInstrutor = this.getAttribute('data-id-instrutor'); // ID para pré-seleção
                const sala = this.getAttribute('data-sala');
                const idSala = this.getAttribute('data-id-sala');
                const cursoNome = this.getAttribute('data-curso-nome'); // NOVO: Obtém o nome do curso
                const tipoAula = this.getAttribute('data-tipo-aula');
                const motivoFalta = this.getAttribute('data-motivo-falta');
                const statusAula = this.getAttribute('data-status-aula'); 

                document.getElementById('edit_id_aula').value = aulaId;
                document.getElementById('display_aula_id').textContent = aulaId;
                document.getElementById('display_data_aula').textContent = dataAula;
                document.getElementById('display_dia_aula').textContent = diaAula;
                document.getElementById('display_periodo_aula').textContent = periodoAula;
                document.getElementById('display_instrutor_nome').textContent = instrutorNome || 'N/A';
                document.getElementById('display_sala').textContent = sala;
                document.getElementById('display_curso_nome').textContent = cursoNome || 'N/A'; // ADICIONADO: Exibe o nome do curso no modal
                document.getElementById('display_tipo_aula').textContent = tipoAula;
                document.getElementById('display_status_aula').textContent = statusAula; 
                document.getElementById('edit_motivo_falta').value = motivoFalta;

                // Popula dropdown de instrutores no modal
                await populateDropdown(editInstrutorSelect, 'instrutores', idInstrutor);
                // Popula dropdown de salas no modal
                await populateDropdown(editSalaSelect, 'salas', idSala);
                editStatusSelect.value = statusAula; // Define o status atual no select

                editAulaModal.show();
            }

            // Lidar com o envio do formulário de edição da aula
            editAulaForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const formData = new FormData(this); 
                const aulaId = document.getElementById('edit_id_aula').value; 
                formData.append('id_aula', aulaId); // Garante que o ID da aula está no FormData

                // Coletar valores selecionados ou manter vazio se "Manter..." for selecionado
                const novoIdInstrutor = editInstrutorSelect.value === "" ? null : editInstrutorSelect.value;
                const novaIdSala = editSalaSelect.value === "" ? null : editSalaSelect.value;
                const novoStatusAula = editStatusSelect.value; 

                formData.set('novo_id_instrutor', novoIdInstrutor); // Sobrescreve para garantir null se vazio
                formData.set('nova_id_sala', novaIdSala); // Sobrescreve para garantir null se vazio
                formData.set('novo_status_aula', novoStatusAula); 

                try {
                    const response = await fetch('php/update_aula_general.php', { 
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (result.success) {
                        alert('Aula atualizada com sucesso!');
                        editAulaModal.hide(); 
                        fetchAulas(); // Recarrega a tabela para mostrar as alterações
                    } else {
                        alert('Erro ao atualizar aula: ' + result.message);
                    }
                } catch (error) {
                    console.error('Erro ao enviar formulário de atualização:', error);
                    alert('Erro inesperado ao atualizar aula.');
                }
            });


            // Inicializa populando os dropdowns de filtro e buscando as aulas
            populateDropdown(instrutorSelect, 'instrutores');
            populateDropdown(salaSelect, 'salas');
            
            filterForm.addEventListener('submit', fetchAulas);
            // Chama fetchAulas no carregamento inicial da página
            fetchAulas(); 
        });
    </script>
</body>
</html>