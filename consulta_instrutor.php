<?php
include 'php/_check_session.php'; 

$id_instrutor_logado = $_SESSION['id_instrutor'] ?? null; 
$nome_instrutor_logado = $_SESSION['username'] ?? 'Usuário Desconhecido'; 
$user_role = $_SESSION['user_role'] ?? 'instrutor'; // Pegando o role do usuário
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
                        <span class="navbar-text me-3">Olá, <?php echo htmlspecialchars($nome_instrutor_logado); ?>!</span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-primary" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Consulta de Horário do Instrutor</h1> <div class="card p-4">
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
                        <label for="usuarioLogado" class="form-label">Usuário Logado:</label> <input type="text" class="form-control" id="usuarioLogado" value="<?php echo htmlspecialchars($nome_instrutor_logado); ?>" readonly>
                        <input type="hidden" id="idInstrutorLogado" name="idInstrutorLogado" value="<?php echo htmlspecialchars($id_instrutor_logado); ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="instrutor" class="form-label">Filtrar por Instrutor:</label> <select class="form-select" id="instrutor" name="instrutor">
                            <option value="">- Selecione -</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-end justify-content-end"> <button type="submit" class="btn btn-primary me-2">Buscar Horário</button> <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Voltar ao Menu</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="mt-4 table-responsive">
            <h4>Detalhamento das Aulas</h4> <div id="loadingMessage" class="text-center" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Carregando...</span>
                </div>
                <p>Carregando dados das aulas...</p>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Aula ID</th> <th>Data</th>
                        <th>Dia da Semana</th> <th>Manhã</th>
                        <th>Tarde</th>
                        <th>Noite</th>
                        <?php if ($user_role === 'admin'): ?>
                            <th>Ações</th> 
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="aulasTableBody">
                    <tr>
                        <td colspan="<?php echo ($user_role === 'admin' ? '7' : '6'); ?>" class="text-center">Nenhum dado para exibir. Utilize os filtros acima.</td>
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
                        <p><strong>Matéria:</strong> <span id="display_materia"></span></p>
                        <p><strong>Turma:</strong> <span id="display_turma"></span></p>
                        <p><strong>Sala:</strong> <span id="display_sala"></span></p>
                        <p><strong>Tipo:</strong> <span id="display_tipo_aula"></span></p>
                        
                        <hr>
                        <h6>Atualizar Informações da Aula:</h6>
                        <div class="mb-3">
                            <label for="edit_instrutor" class="form-label">Trocar Instrutor (Opcional):</label>
                            <select class="form-select" id="edit_instrutor" name="novo_id_instrutor">
                                <option value="">- Manter instrutor atual -</option> </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_motivo_falta" class="form-label">Observações da Aula (Opcional):</label> <textarea class="form-control" id="edit_motivo_falta" name="motivo_falta" rows="3" placeholder="Ex: Instrutor faltou, aula cancelada, aula remarcada, etc."></textarea>
                            <small class="form-text text-muted">Este campo pode ser usado para registrar o motivo de ausência, troca de professor ou outras observações.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button> <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        console.log("Script consulta_instrutor.php versão: 2025-06-11 16:15 - Estilo e Funções Admin");

        document.addEventListener('DOMContentLoaded', async function() {
            const filterForm = document.getElementById('filterForm');
            const aulasTableBody = document.getElementById('aulasTableBody');
            const errorMessageDiv = document.getElementById('errorMessage');
            const loadingMessageDiv = document.getElementById('loadingMessage');
            const dataInicialInput = document.getElementById('dataInicial');
            const dataFinalInput = document.getElementById('dataFinal');
            const instrutorSelect = document.getElementById('instrutor');
            const idInstrutorLogadoInput = document.getElementById('idInstrutorLogado'); 
            const userRole = '<?php echo $user_role; ?>'; 

            // Preenche as datas com o dia atual, se estiverem vazias
            const today = new Date();
            const year = today.getFullYear();
            const month = (today.getMonth() + 1).toString().padStart(2, '0');
            const day = today.getDate().toString().padStart(2, '0');
            const formattedDate = `${year}-${month}-${day}`;
            
            if (!dataInicialInput.value) { // Só preenche se não houver um valor já definido
                dataInicialInput.value = formattedDate;
            }
            if (!dataFinalInput.value) { // Só preenche se não houver um valor já definido
                dataFinalInput.value = formattedDate;
            }

            // Variáveis para o modal de edição
            const editAulaModal = new bootstrap.Modal(document.getElementById('editAulaModal'));
            const editAulaForm = document.getElementById('editAulaForm');
            const editInstrutorSelect = document.getElementById('edit_instrutor');

            // Função para exibir mensagem de erro
            function showErrorMessage(message) {
                errorMessageDiv.textContent = message;
                errorMessageDiv.style.display = 'block';
                setTimeout(() => errorMessageDiv.style.display = 'none', 7000);
            }

            // Função para popular o dropdown de instrutores (tanto no filtro quanto no modal)
            async function populateInstrutorDropdown(selectElement, selectedId = null) {
                try {
                    // Use 'instrutores_all' para o modal e para o filtro, se desejar ver todos os instrutores cadastrados
                    // Se quiser que o filtro mostre APENAS instrutores com aulas, use 'instrutores'
                    const endpoint = (selectElement.id === 'edit_instrutor' || userRole === 'admin') ? 'instrutores_all' : 'instrutores';
                    const response = await fetch(`php/get_filters.php?get=${endpoint}`); 
                    if (!response.ok) {
                        throw new Error(`Erro HTTP: ${response.status} ${response.statusText}`);
                    }
                    const data = await response.json();

                    selectElement.innerHTML = '<option value="">- Selecione -</option>'; 
                    if (selectElement.id === 'edit_instrutor') {
                        selectElement.innerHTML = '<option value="">- Manter instrutor atual -</option>'; 
                    }

                    if (data.instrutores) {
                        data.instrutores.forEach(instrutor => {
                            const option = document.createElement('option');
                            option.value = instrutor.id;
                            option.textContent = instrutor.nome;
                            selectElement.appendChild(option);
                        });
                    }
                    if (selectedId) {
                        selectElement.value = selectedId;
                    }

                } catch (error) {
                    console.error('Erro ao popular instrutores:', error);
                    showErrorMessage('Erro ao carregar opções de instrutor. Tente novamente.');
                }
            }

            // Função para buscar e exibir as aulas do instrutor
            async function fetchAulasInstrutor(event) {
                if (event) event.preventDefault();

                const dataInicial = dataInicialInput.value;
                const dataFinal = dataFinalInput.value;
                const selectedInstrutorId = instrutorSelect.disabled ? idInstrutorLogadoInput.value : instrutorSelect.value;
                
                if (!selectedInstrutorId) {
                    showErrorMessage('Por favor, selecione um instrutor para buscar.');
                    aulasTableBody.innerHTML = `<tr><td colspan="${userRole === 'admin' ? '7' : '6'}" class="text-center">Nenhum dado para exibir. Utilize os filtros acima.</td></tr>`;
                    loadingMessageDiv.style.display = 'none';
                    return;
                }

                if (!dataInicial || !dataFinal) {
                    showErrorMessage('Por favor, preencha as datas inicial e final.');
                    aulasTableBody.innerHTML = `<tr><td colspan="${userRole === 'admin' ? '7' : '6'}" class="text-center">Nenhum dado para exibir. Utilize os filtros acima.</td></tr>`;
                    loadingMessageDiv.style.display = 'none';
                    return;
                }

                aulasTableBody.innerHTML = '';
                errorMessageDiv.style.display = 'none';
                loadingMessageDiv.style.display = 'block';

                const formData = new FormData();
                formData.append('dataInicial', dataInicial);
                formData.append('dataFinal', dataFinal);
                formData.append('idInstrutor', selectedInstrutorId); 

                try {
                    const response = await fetch('php/get_aulas_instrutor.php', { 
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
                                    
                                    row.insertCell().textContent = aulasDoDia.id_aula_display || '-'; 
                                    row.insertCell().textContent = date_aula; 
                                    row.insertCell().textContent = aulasDoDia.dia_semana; 
                                    
                                    // Conteúdo Manhã
                                    const cellManha = row.insertCell();
                                    if (aulasDoDia.manha) {
                                        cellManha.innerHTML = `<div class="aula-content">${aulasDoDia.manha.content}</div>`;
                                        if (userRole === 'admin') {
                                            const btnManha = document.createElement('button');
                                            btnManha.className = 'btn btn-info btn-sm btn-sm-custom mt-1';
                                            btnManha.textContent = 'Editar';
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
                                        cellTarde.innerHTML = `<div class="aula-content">${aulasDoDia.tarde.content}</div>`;
                                        if (userRole === 'admin') {
                                            const btnTarde = document.createElement('button');
                                            btnTarde.className = 'btn btn-info btn-sm btn-sm-custom mt-1';
                                            btnTarde.textContent = 'Editar';
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
                                        cellNoite.innerHTML = `<div class="aula-content">${aulasDoDia.noite.content}</div>`;
                                        if (userRole === 'admin') {
                                            const btnNoite = document.createElement('button');
                                            btnNoite.className = 'btn btn-info btn-sm btn-sm-custom mt-1';
                                            btnNoite.textContent = 'Editar';
                                            btnNoite.setAttribute('data-id-aula', aulasDoDia.noite.id_aula);
                                            btnNoite.setAttribute('data-aula-details', JSON.stringify(aulasDoDia.noite));
                                            cellNoite.appendChild(btnNoite);
                                        }
                                    } else {
                                        cellNoite.textContent = '-';
                                    }

                                    // Coluna Ações (para Admin)
                                    if (userRole === 'admin') {
                                        // Não precisa adicionar um botão aqui se os botões "Editar" já estão nas células de período.
                                        // Esta célula fica vazia ou pode ser usada para ações gerais do dia.
                                        row.insertCell().textContent = ''; 
                                    }
                                }
                            }

                            // Adicionar event listeners aos botões de edição DEPOIS que eles são criados
                            document.querySelectorAll('.btn-info.btn-sm').forEach(button => {
                                button.addEventListener('click', function() {
                                    const aulaId = this.getAttribute('data-id-aula');
                                    const aulaDetails = JSON.parse(this.getAttribute('data-aula-details'));
                                    
                                    // Preencher o modal com os detalhes da aula
                                    document.getElementById('edit_id_aula').value = aulaId;
                                    document.getElementById('display_aula_id').textContent = aulaId;
                                    document.getElementById('display_data_aula').textContent = aulaDetails.data_aula_formatada;
                                    document.getElementById('display_dia_aula').textContent = aulaDetails.dia_semana_pt;
                                    document.getElementById('display_periodo_aula').textContent = aulaDetails.periodo_aula;
                                    document.getElementById('display_materia').textContent = aulaDetails.nome_materia;
                                    document.getElementById('display_turma').textContent = aulaDetails.nome_turma;
                                    document.getElementById('display_sala').textContent = aulaDetails.nome_sala;
                                    document.getElementById('display_tipo_aula').textContent = aulaDetails.tipo_aula;
                                    
                                    // Preencher o dropdown de troca de instrutor no modal
                                    populateInstrutorDropdown(editInstrutorSelect, aulaDetails.id_instrutor); 
                                    
                                    // Preencher o motivo da falta (se existir)
                                    document.getElementById('edit_motivo_falta').value = aulaDetails.motivo_falta || '';

                                    editAulaModal.show();
                                });
                            });

                        } else {
                            aulasTableBody.innerHTML = `<tr><td colspan="${userRole === 'admin' ? '7' : '6'}" class="text-center">${data.message}</td></tr>`;
                        }
                    } else {
                        aulasTableBody.innerHTML = `<tr><td colspan="${userRole === 'admin' ? '7' : '6'}" class="text-center">${data.message}</td></tr>`;
                        showErrorMessage('Erro na consulta: ' + data.message);
                    }
                } catch (error) {
                    console.error('Erro na requisição de aulas do instrutor:', error);
                    aulasTableBody.innerHTML = `<tr><td colspan="${userRole === 'admin' ? '7' : '6'}" class="text-center">Ocorreu um erro ao buscar os dados.</td></tr>`;
                    showErrorMessage('Ocorreu um erro inesperado ao carregar as aulas. Tente novamente.');
                } finally {
                    loadingMessageDiv.style.display = 'none';
                }
            }

            // Função para lidar com o envio do formulário de edição do modal
            editAulaForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const formData = new FormData(this); 
                const aulaId = document.getElementById('edit_id_aula').value; 

                formData.append('id_aula', aulaId);

                try {
                    const response = await fetch('php/update_aula_instrutor.php', { 
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (result.success) {
                        alert('Aula atualizada com sucesso!');
                        editAulaModal.hide(); 
                        fetchAulasInstrutor(); // Recarrega a tabela para mostrar as alterações
                    } else {
                        alert('Erro ao atualizar aula: ' + result.message);
                    }
                } catch (error) {
                    console.error('Erro ao enviar formulário de atualização:', error);
                    alert('Erro inesperado ao atualizar aula.');
                }
            });


            // --- Event Listeners ---
            populateInstrutorDropdown(instrutorSelect); 
            // Lógica de desabilitação do dropdown para não-administradores - Movido para aqui
            if (userRole !== 'admin') { 
                const idLogado = idInstrutorLogadoInput.value;
                if (idLogado) {
                    instrutorSelect.value = idLogado;
                    instrutorSelect.disabled = true; 
                }
            }

            filterForm.addEventListener('submit', fetchAulasInstrutor); 
            fetchAulasInstrutor(); 
        });
    </script>
</body>
</html>