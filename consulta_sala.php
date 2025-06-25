<?php
include 'php/_check_session.php'; 

$id_usuario_logado = $_SESSION['id_usuario'] ?? null;
$nome_usuario_logado = $_SESSION['username'] ?? 'Usuário Desconhecido'; 
$user_role = $_SESSION['user_role'] ?? 'visitante';
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
        <h1>Consulta de Horário por Sala</h1>

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
                        <label for="usuarioLogado" class="form-label">Usuário Logado:</label>
                        <input type="text" class="form-control" id="usuarioLogado" value="<?php echo htmlspecialchars($nome_usuario_logado); ?>" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="sala" class="form-label">Filtrar por Sala:</label>
                        <select class="form-select" id="sala" name="sala">
                            <option value="">- Selecione -</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-end justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">Buscar Horário</button>
                        <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Voltar ao Menu</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="mt-4 table-responsive">
            <h4>Detalhamento das Aulas por Sala</h4>
            <div id="loadingMessage" class="text-center" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Carregando...</span>
                </div>
                <p>Carregando dados das aulas...</p>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Aula ID</th>
                        <th>Data</th>
                        <th>Dia da Semana</th>
                        <th>Capacidade</th> 
                        <th>Manhã</th>
                        <th>Tarde</th>
                        <th>Noite</th>
                        <?php if ($user_role === 'admin'): ?>
                            <th>Ações</th> 
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="aulasTableBody">
                    <tr>
                        <td colspan="<?php echo ($user_role === 'admin' ? '8' : '7'); ?>" class="text-center">Nenhum dado para exibir. Utilize os filtros acima.</td>
                    </tr>
                </tbody>
            </table>
            <div id="errorMessage" class="alert alert-danger mt-3" style="display: none;"></div>
        </div>
    </div>

    <div class="modal fade" id="editAulaSalaModal" tabindex="-1" aria-labelledby="editAulaSalaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAulaSalaModalLabel">Trocar Sala da Aula</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editAulaSalaForm">
                    <div class="modal-body">
                        <input type="hidden" id="edit_sala_id_aula" name="id_aula">
                        <p><strong>ID da Aula:</strong> <span id="display_sala_aula_id"></span></p>
                        <p><strong>Data:</strong> <span id="display_sala_data_aula"></span></p>
                        <p><strong>Período:</strong> <span id="display_sala_periodo_aula"></span></p>
                        <p><strong>Matéria:</strong> <span id="display_sala_materia"></span></p>
                        <p><strong>Turma:</strong> <span id="display_sala_turma"></span></p>
                        <p><strong>Instrutor:</strong> <span id="display_sala_instrutor"></span></p>
                        <p><strong>Sala Atual:</strong> <span id="display_sala_atual"></span></p>
                        
                        <hr>
                        <h6>Selecionar Nova Sala:</h6>
                        <div class="mb-3">
                            <label for="nova_sala" class="form-label">Nova Sala:</label>
                            <select class="form-select" id="nova_sala" name="nova_id_sala" required>
                                <option value="">- Selecione a nova sala -</option>
                            </select>
                            <small class="form-text text-muted">A nova sala deve ter capacidade compatível e estar disponível no horário.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar Troca de Sala</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        console.log("Script consulta_sala.php versão: 2025-06-11 16:45 - Com Edição de Sala");

        document.addEventListener('DOMContentLoaded', async function() {
            const filterForm = document.getElementById('filterForm');
            const aulasTableBody = document.getElementById('aulasTableBody');
            const errorMessageDiv = document.getElementById('errorMessage');
            const loadingMessageDiv = document.getElementById('loadingMessage');
            const dataInicialInput = document.getElementById('dataInicial');
            const dataFinalInput = document.getElementById('dataFinal');
            const salaSelect = document.getElementById('sala'); 
            const userRole = '<?php echo $user_role; ?>';

            // Modal de edição de sala
            const editAulaSalaModal = new bootstrap.Modal(document.getElementById('editAulaSalaModal'));
            const editAulaSalaForm = document.getElementById('editAulaSalaForm');
            const novaSalaSelect = document.getElementById('nova_sala');

            // Preenche as datas com o dia atual, se estiverem vazias
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

            function showErrorMessage(message) {
                errorMessageDiv.textContent = message;
                errorMessageDiv.style.display = 'block';
                setTimeout(() => errorMessageDiv.style.display = 'none', 7000);
            }

            // Função para popular o dropdown de salas para o filtro principal
            async function populateSalaDropdown() {
                try {
                    const response = await fetch('php/get_filters.php?get=salas_all');
                    if (!response.ok) {
                        throw new Error(`Erro HTTP: ${response.status} ${response.statusText}`);
                    }
                    const data = await response.json();

                    salaSelect.innerHTML = '<option value="">- Selecione -</option>';
                    if (data.salas) {
                        data.salas.forEach(sala => {
                            const option = document.createElement('option');
                            option.value = sala.id;
                            option.textContent = sala.nome;
                            salaSelect.appendChild(option);
                        });
                    }

                } catch (error) {
                    console.error('Erro ao popular salas:', error);
                    showErrorMessage('Erro ao carregar opções de sala. Tente novamente.');
                }
            }

            // Função para popular o dropdown de todas as salas (para o modal de edição)
            async function populateAllSalasDropdown(selectElement, excludeId = null, selectedId = null) {
                try {
                    const response = await fetch(`php/get_filters.php?get=salas_all`); 
                    if (!response.ok) {
                        throw new Error(`Erro HTTP: ${response.status} ${response.statusText}`);
                    }
                    const data = await response.json();

                    selectElement.innerHTML = '<option value="">- Selecione a nova sala -</option>'; 
                    if (data.salas) {
                        data.salas.forEach(sala => {
                            // Não adiciona a sala atual à lista de opções para trocar
                            if (excludeId && sala.id == excludeId) {
                                // Pode adicionar, mas desabilitar ou mudar o texto
                                // Para este caso, vamos omitir, pois o objetivo é trocar.
                                return; 
                            }
                            const option = document.createElement('option');
                            option.value = sala.id;
                            option.textContent = sala.nome;
                            selectElement.appendChild(option);
                        });
                    }
                    if (selectedId) { // Se houver uma sala pré-selecionada (útil se o modal for mais complexo)
                        selectElement.value = selectedId;
                    }

                } catch (error) {
                    console.error('Erro ao popular todas as salas:', error);
                    showErrorMessage('Erro ao carregar opções de sala para o modal. Tente novamente.');
                }
            }


            async function fetchAulasSala(event) {
                if (event) event.preventDefault();

                const dataInicial = dataInicialInput.value;
                const dataFinal = dataFinalInput.value;
                const selectedSalaId = salaSelect.value;
                
                if (!selectedSalaId) {
                    showErrorMessage('Por favor, selecione uma sala para buscar.');
                    aulasTableBody.innerHTML = `<tr><td colspan="${userRole === 'admin' ? '8' : '7'}" class="text-center">Nenhum dado para exibir. Utilize os filtros acima.</td></tr>`;
                    loadingMessageDiv.style.display = 'none';
                    return;
                }

                if (!dataInicial || !dataFinal) {
                    showErrorMessage('Por favor, preencha as datas inicial e final.');
                    aulasTableBody.innerHTML = `<tr><td colspan="${userRole === 'admin' ? '8' : '7'}" class="text-center">Nenhum dado para exibir. Utilize os filtros acima.</td></tr>`;
                    loadingMessageDiv.style.display = 'none';
                    return;
                }

                aulasTableBody.innerHTML = '';
                errorMessageDiv.style.display = 'none';
                loadingMessageDiv.style.display = 'block';

                const formData = new FormData();
                formData.append('dataInicial', dataInicial);
                formData.append('dataFinal', dataFinal);
                formData.append('idSala', selectedSalaId);

                try {
                    const response = await fetch('php/get_aulas_sala.php', {
                        method: 'POST',
                        body: formData
                    });

                    if (!response.ok) {
                        throw new Error(`Erro HTTP: ${response.status} ${response.statusText}`);
                    }

                    const data = await response.json();
                    
                    if (data.success) {
                        if (Object.keys(data.data).length > 0) { 
                            aulasTableBody.innerHTML = '';
                            for (const date_aula in data.data) { 
                                if (data.data.hasOwnProperty(date_aula)) {
                                    const aulasDoDia = data.data[date_aula];
                                    const row = aulasTableBody.insertRow();
                                    
                                    // ID da aula será do primeiro período encontrado no dia
                                    row.insertCell().textContent = aulasDoDia.id_aula_manha || aulasDoDia.id_aula_tarde || aulasDoDia.id_aula_noite || '-'; 
                                    row.insertCell().textContent = date_aula; 
                                    row.insertCell().textContent = aulasDoDia.dia_semana; 
                                    row.insertCell().textContent = aulasDoDia.capacidade_sala || '-';

                                    // Conteúdo Manhã
                                    const cellManha = row.insertCell();
                                    if (aulasDoDia.manha) {
                                        cellManha.innerHTML = `<div class="aula-content">
                                            <strong>${htmlspecialchars(aulasDoDia.manha.nome_materia)}</strong><br>
                                            ${htmlspecialchars(aulasDoDia.manha.nome_turma)}<br>
                                            ${htmlspecialchars(aulasDoDia.manha.nome_instrutor)} (${htmlspecialchars(aulasDoDia.manha.tipo_aula)})
                                        </div>`;
                                        if (userRole === 'admin') {
                                            const btnManha = document.createElement('button');
                                            btnManha.className = 'btn btn-primary btn-sm btn-edit-sala mt-1'; // Usando nova classe
                                            btnManha.textContent = 'Trocar Sala';
                                            btnManha.setAttribute('data-id-aula', aulasDoDia.manha.id_aula);
                                            btnManha.setAttribute('data-aula-details', JSON.stringify(aulasDoDia.manha)); 
                                            cellManha.appendChild(btnManha);
                                        }
                                    } else {
                                        cellManha.textContent = '-';
                                    }

                                    // Conteúdo Tarde
                                    const cellTarde = row.insertCell();
                                    if (aulasDoDia.tarde) {
                                        cellTarde.innerHTML = `<div class="aula-content">
                                            <strong>${htmlspecialchars(aulasDoDia.tarde.nome_materia)}</strong><br>
                                            ${htmlspecialchars(aulasDoDia.tarde.nome_turma)}<br>
                                            ${htmlspecialchars(aulasDoDia.tarde.nome_instrutor)} (${htmlspecialchars(aulasDoDia.tarde.tipo_aula)})
                                        </div>`;
                                        if (userRole === 'admin') {
                                            const btnTarde = document.createElement('button');
                                            btnTarde.className = 'btn btn-primary btn-sm btn-edit-sala mt-1';
                                            btnTarde.textContent = 'Trocar Sala';
                                            btnTarde.setAttribute('data-id-aula', aulasDoDia.tarde.id_aula);
                                            btnTarde.setAttribute('data-aula-details', JSON.stringify(aulasDoDia.tarde));
                                            cellTarde.appendChild(btnTarde);
                                        }
                                    } else {
                                        cellTarde.textContent = '-';
                                    }

                                    // Conteúdo Noite
                                    const cellNoite = row.insertCell();
                                    if (aulasDoDia.noite) {
                                        cellNoite.innerHTML = `<div class="aula-content">
                                            <strong>${htmlspecialchars(aulasDoDia.noite.nome_materia)}</strong><br>
                                            ${htmlspecialchars(aulasDoDia.noite.nome_turma)}<br>
                                            ${htmlspecialchars(aulasDoDia.noite.nome_instrutor)} (${htmlspecialchars(aulasDoDia.noite.tipo_aula)})
                                        </div>`;
                                        if (userRole === 'admin') {
                                            const btnNoite = document.createElement('button');
                                            btnNoite.className = 'btn btn-primary btn-sm btn-edit-sala mt-1';
                                            btnNoite.textContent = 'Trocar Sala';
                                            btnNoite.setAttribute('data-id-aula', aulasDoDia.noite.id_aula);
                                            btnNoite.setAttribute('data-aula-details', JSON.stringify(aulasDoDia.noite));
                                            cellNoite.appendChild(btnNoite);
                                        }
                                    } else {
                                        cellNoite.textContent = '-';
                                    }

                                    // Coluna Ações (para Admin)
                                    if (userRole === 'admin') {
                                        row.insertCell().textContent = ''; // Vazia, pois o botão está dentro da célula do período
                                    }
                                }
                            }

                            // Adicionar event listeners aos botões de edição de sala
                            document.querySelectorAll('.btn-edit-sala').forEach(button => {
                                button.addEventListener('click', function() {
                                    const aulaId = this.getAttribute('data-id-aula');
                                    const aulaDetails = JSON.parse(this.getAttribute('data-aula-details'));
                                    
                                    // Preencher o modal com os detalhes da aula
                                    document.getElementById('edit_sala_id_aula').value = aulaId;
                                    document.getElementById('display_sala_aula_id').textContent = aulaId;
                                    document.getElementById('display_sala_data_aula').textContent = aulaDetails.data_aula_formatada;
                                    document.getElementById('display_sala_periodo_aula').textContent = aulaDetails.periodo_aula;
                                    document.getElementById('display_sala_materia').textContent = aulaDetails.nome_materia;
                                    document.getElementById('display_sala_turma').textContent = aulaDetails.nome_turma;
                                    document.getElementById('display_sala_instrutor').textContent = aulaDetails.nome_instrutor;
                                    document.getElementById('display_sala_atual').textContent = aulaDetails.nome_sala;
                                    
                                    // Popula o dropdown de "Nova Sala", excluindo a sala atual
                                    populateAllSalasDropdown(novaSalaSelect, aulaDetails.id_sala); 

                                    editAulaSalaModal.show();
                                });
                            });

                        } else {
                            aulasTableBody.innerHTML = `<tr><td colspan="${userRole === 'admin' ? '8' : '7'}" class="text-center">${data.message}</td></tr>`;
                        }
                    } else {
                        aulasTableBody.innerHTML = `<tr><td colspan="${userRole === 'admin' ? '8' : '7'}" class="text-center">${data.message}</td></tr>`;
                        showErrorMessage('Erro na consulta: ' + data.message);
                    }
                } catch (error) {
                    console.error('Erro na requisição de aulas da sala:', error);
                    aulasTableBody.innerHTML = `<tr><td colspan="${userRole === 'admin' ? '8' : '7'}" class="text-center">Ocorreu um erro ao buscar os dados.</td></tr>`;
                    showErrorMessage('Ocorreu um erro inesperado ao carregar as aulas. Tente novamente.');
                } finally {
                    loadingMessageDiv.style.display = 'none';
                }
            }

            // Função de escape HTML simples para garantir segurança ao exibir dados
            function htmlspecialchars(str) {
                if (typeof str !== 'string') return str; 
                var map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                };
                return str.replace(/[&<>"']/g, function(m) { return map[m]; });
            }


            // --- Lidar com o envio do formulário de EDIÇÃO DE SALA ---
            editAulaSalaForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const formData = new FormData(this); 
                const aulaId = document.getElementById('edit_sala_id_aula').value; 
                const novaIdSala = document.getElementById('nova_sala').value;

                if (!novaIdSala) {
                    alert('Por favor, selecione uma nova sala.');
                    return;
                }

                formData.append('id_aula', aulaId);
                formData.append('nova_id_sala', novaIdSala);

                try {
                    const response = await fetch('php/update_aula_sala.php', { // NOVO SCRIPT PHP
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (result.success) {
                        alert('Sala da aula atualizada com sucesso!');
                        editAulaSalaModal.hide(); 
                        fetchAulasSala(); // Recarrega a tabela da sala para mostrar as alterações
                    } else {
                        alert('Erro ao atualizar sala da aula: ' + result.message);
                    }
                } catch (error) {
                    console.error('Erro ao enviar formulário de atualização da sala:', error);
                    alert('Erro inesperado ao atualizar sala da aula.');
                }
            });


            // --- Event Listeners ---
            populateSalaDropdown(); 
            filterForm.addEventListener('submit', fetchAulasSala); 
        });
        document.addEventListener('DOMContentLoaded', function() {
    // ... suas outras constantes e variáveis ...

    // --- NOVA VARIÁVEL PARA SIMULAR O ADMIN ---
    // Em um sistema real, essa variável viria do PHP, após a autenticação.
    // Por enquanto, defina-a como true para ver o botão, ou false para escondê-lo.
    const isAdmin = true; // Mude para 'false' para esconder o botão de excluir

    // ... suas outras funções (loadAulas, showMessage, etc.) ...

    function displayAulas(aulas) {
        tableBody.innerHTML = ''; // Limpa o corpo da tabela
        if (aulas.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="13">Nenhuma aula encontrada para os filtros aplicados.</td></tr>'; // Aumente o colspan
            return;
        }

        aulas.forEach(aula => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${aula.id_aula}</td>
                <td>${aula.data_aula_formatada} (${aula.dia_semana_pt})</td>
                <td>${aula.periodo_aula}</td>
                <td>${aula.nome_turma}</td>
                <td>${aula.nome_instrutor}</td>
                <td>${aula.nome_sala}</td>
                <td>${aula.tipo_aula}</td>
                <td>${aula.motivo_falta ? aula.motivo_falta : '-'}</td>
                <td>${aula.status_turma ? aula.status_turma : 'N/A'}</td>
                <td>
                    <button class="btn-editar" data-id="${aula.id_aula}">Editar</button>
                    ${isAdmin ? `<button class="btn-excluir" data-id="${aula.id_aula}">Excluir</button>` : ''}
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Adiciona event listeners para os botões após eles serem criados
        document.querySelectorAll('.btn-editar').forEach(button => {
            button.addEventListener('click', function() {
                const aulaId = this.dataset.id;
                // Lógica para editar aula (você já tem isso, ou podemos implementar depois)
                alert('Editar aula com ID: ' + aulaId);
            });
        });

        // --- NOVO EVENT LISTENER PARA O BOTÃO EXCLUIR ---
        if (isAdmin) { // Apenas adicione listeners se os botões foram criados
            document.querySelectorAll('.btn-excluir').forEach(button => {
                button.addEventListener('click', function() {
                    const aulaId = this.dataset.id;
                    if (confirm('Tem certeza que deseja excluir a aula com ID ' + aulaId + '?')) {
                        excluirAula(aulaId); // Chama a função para excluir
                    }
                });
            });
        }
    }

    // --- NOVA FUNÇÃO PARA EXCLUIR AULA (Chamará um script PHP) ---
    function excluirAula(id_aula) {
        fetch('php/excluir_aula.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id_aula: id_aula })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('Aula excluída com sucesso!', 'success');
                // Recarregar as aulas após a exclusão para atualizar a tabela
                loadAulas(); 
            } else {
                showMessage('Erro ao excluir aula: ' + data.message, 'error');
            }
        })
        .catch(error => {
            showMessage('Erro na requisição de exclusão.', 'error');
            console.error('Erro:', error);
        });
    }

    // ... o restante do seu JavaScript (event listeners para o formulário de filtro) ...
});
    </script>
</body>
</html>