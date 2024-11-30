<?php 
include_once("../includes/config.inc.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $curso = trim($_POST['curso']);
    $senha = trim($_POST['senha']);

    if (empty($nome) || empty($email) || empty($curso) || empty($senha)) {
        echo "Todos os campos devem ser preenchidos";
        exit;  
    }

    // Validar o curso
    $cursos_validos = ['Administração', 'Sistemas de Informação', 'Direito', 'Ciencias da Computação', 'Enfermagem'];
    if (!in_array($curso, $cursos_validos)) {
        echo "Selecione um curso válido!";
        exit;
    }

    // Verificar se o email já está cadastrado
    $sql_check_email = "SELECT * FROM alunos WHERE email = ?";
    $stmt = $conexao->prepare($sql_check_email);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "O e-mail já está cadastrado!";
        exit;
    } else {
        // Criptografar a senha antes de salvar
        $password_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Inserir dados na tabela "alunos"
        $sql = "INSERT INTO alunos (username, email, password_hash, curso, tipo) VALUES (?, ?, ?, ?, 'aluno')";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssss", $nome, $email, $password_hash, $curso);

        if ($stmt->execute()) {
            echo "Cadastro realizado com sucesso!";
            header("Location: ../login/login.php");
            exit;
        } else {
            echo "Erro ao cadastrar: " . $conexao->error;
        }
    }
}
?>
