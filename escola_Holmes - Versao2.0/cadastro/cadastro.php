<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Faculdade Holmes</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style> 
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f9;
    }
    .navbar {
        background-color: #333;
        color: #fff;
        padding: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .navbar h1 {
        margin: 0;
    }
    .login-link {
        text-decoration: none;
        color: #f9a826;
    }
    main {
        padding: 2rem;
        max-width: 600px;
        margin: 2rem auto;
        background: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }
    form input, form select, button {
        width: 100%;
        padding: 0.8rem;
        margin-bottom: 1rem;
        border: 1px solid #ccc;
        border-radius: 5px; 
    }
    form button {
        background-color: #333;
        color: white;
        border: none;
        cursor: pointer;
    }
    form button:hover {
        background-color: #444;
    }
    footer {
        text-align: center;
        padding: 1rem;
        background: #333;
        color: #fff;
        position: fixed;
        width: 100%;
        bottom: 0;
    }
</style>
</head>
<body>
    <header>
        <div class="navbar">
            <h1>Faculdade Holmes</h1>
            <a href="../login/login.php" class="login-link">Login</a>
        </div>
    </header>

    <main>
        <h2>Inscreva-se Agora</h2>
        <form action="processar_cadastro.php" method="POST">
            <label for="nome">Nome Completo:</label>
            <input type="text" id="nome" name="nome" placeholder="Seu Nome" required>
            
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" placeholder="seuemail@email.com" required>
            
            <label for="curso">Selecione o Curso:</label>
            <select id="curso" name="curso" required>
                <option value="">Escolha um curso</option>
                <option value="Administração">Administração</option>
                <option value="Sistemas de Informação">Sistemas de Informação</option>
                <option value="Direito">Direito</option>
                <option value="Ciencias da Computação">Ciencias da Computação</option>
                <option value="Enfermagem">Enfermagem</option>
            </select>
            
            <label for="senha">Crie uma Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Digite uma senha" required>
            
            <button type="submit" class="btn">Cadastrar</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Faculdade Holmes. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
