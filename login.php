<?php
// Certifique-se que session_start() está no topo do seu login.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Remove qualquer mensagem de erro antiga da sessão, se houver
// Isso é importante para que a mensagem antiga não persista se você recarregar a página manualmente
if (isset($_SESSION['login_error'])) {
    unset($_SESSION['login_error']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NETNÚCLEO - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .header-bar {
            background-color: #2a3c50; /* Cor da barra escura acima do menu */
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
            z-index: 1; /* Garante que o texto fique acima de outros elementos se houver sobreposição */
        }
        .login-container {
            background-color: #fff;
            width: 400px;
            margin: 80px auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 20px;
            color: #003366;
            font-size: 24px;
        }
        .login-container label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .login-container input[type="text"],
        .login-container input[type="password"],
        .login-container select {
            width: 100%;
            padding: 8px 12px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        .login-container .btn {
            background-color: #003366;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px; /* Espaço para o ícone da chave */
        }
        .login-container .btn:hover {
            background-color: #0055a5;
        }
        .login-container .key-icon {
            font-size: 50px; /* Tamanho da chave */
            color: #b0c4de; /* Cor da chave, um cinza azulado claro */
            margin-top: 20px;
        }
        .error-message {
            color: red;
            margin-top: 10px;
            font-weight: bold;
        }
        /* Estilos para o campo de senha com "olhinho" */
        .password-container {
            position: relative;
            margin-bottom: 15px; /* Para manter o espaçamento como o input normal */
        }
        .password-container input[type="password"],
        .password-container input[type="text"] { /* Para quando o tipo muda para text */
            width: 100%;
            padding: 8px 40px 8px 12px; /* Adiciona padding à direita para o ícone */
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box; /* Garante que padding não aumente o width total */
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d; /* Cor do ícone */
        }
        .toggle-password:hover {
            color: #343a40;
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
        </div>
    </nav>

    <div class="login-container">
        <h2>Login</h2>
        <form id="loginForm">
            <label for="unidade">Unidade:</label>
            <select class="form-select" name="unidade_id" id="unidade" required>
                <option value="">- Selecione -</option>
                <option value="2" selected>BH - Horto</option>
            </select>

            <label for="usuario">Usuário:</label>
            <input type="text" class="form-control" id="usuario" name="usuario" required>

            <label for="senha">Senha:</label>
            <div class="password-container">
                <input type="password" class="form-control" id="senha" name="senha" required>
                <span class="toggle-password" id="togglePassword">
                    <i class="fas fa-eye"></i> </span>
            </div>

            <div id="errorMessage" class="error-message"></div>

            <button type="submit" class="btn">Entrar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordField = document.getElementById('senha');
            const togglePassword = document.getElementById('togglePassword');

            togglePassword.addEventListener('click', function () {
                // Alternar o tipo do input entre 'password' e 'text'
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                
                // Alternar o ícone do olhinho (aberto/fechado)
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });

            // Código do formulário de login (seu código original)
            document.getElementById('loginForm').addEventListener('submit', async function(event) {
                event.preventDefault();

                const unidade = document.getElementById('unidade').value;
                const usuario = document.getElementById('usuario').value;
                const senha = document.getElementById('senha').value;
                const errorMessageDiv = document.getElementById('errorMessage');

                errorMessageDiv.textContent = ''; // Limpa mensagem anterior

                const formData = new FormData();
                formData.append('unidade_id', unidade);
                formData.append('usuario', usuario);
                formData.append('senha', senha);

                try {
                    const response = await fetch('php/login_handler.php', {
                        method: 'POST',
                        body: formData
                    });

                    if (!response.ok) {
                        throw new Error(`Erro HTTP: ${response.status} ${response.statusText}`);
                    }

                    const data = await response.json();

                    if (data.success) {
                        window.location.href = 'index.php';
                    } else {
                        errorMessageDiv.textContent = data.message;
                    }
                } catch (error) {
                    console.error('Erro na requisição de login (JS):', error);
                    errorMessageDiv.textContent = 'Ocorreu um erro inesperado. Tente novamente.';
                }
            });
        });
    </script>
</body>
</html>