<?php
session_start();

// ve se o usuario tá logado
if (!function_exists('logado')) {
    function logado() {
        return isset($_SESSION['user_id']);
    }
}

// aqui ele indentifica quem o usuario é
if (!function_exists('getRole')) {
    function getRole() {
        return isset($_SESSION['role']) ? $_SESSION['role'] : null;
    }
}

// aqui ele exige que vc faça o login
if (!function_exists('protegepagina')) {
    function protegepagina() {
        if (!logado()) {
            header("Location: ../login/login.php"); // nem sei mais oq eu to fazendo
            exit(); // EU ESQUICI DA MZR DESSE EXIT
        }
    }
}
function verificarTipoUsuario($alunoInfo) {
    // Verifica o tipo de usuario (aluno, professor, admin)
    switch ($alunoInfo['tipo']) {
        case 'aluno':
            return 'aluno';
        case 'professor':
            return 'professor';
        case 'admin':
            return 'admin';
        default:
            return 'invalido';
    }
}
function getAlunoInfo($username) {
    global $conn;
    $query = "SELECT * FROM alunos WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}


//ele manda para a pagina da sua conta especifica (acho que é assim que escreve)
if (!function_exists('redirecionaporrole')) {
    function redirecionaporrole() {
        $role = getRole();

        // msm coisa
        if ($role === 'admin') {
            header("Location: ../admin/index.php");
        } elseif ($role === 'professor') {
            header("Location: ../professor/index.php");
        } elseif ($role === 'aluno') {
            header("Location: ../aluno/index.php");
        } else {
            // se não tiver um lugar para ir ele manda para a pagina de login 
            header("Location: ../login/login.php");
        }
        exit(); //olha o exit aqui dnv dessa vez eu lembrei
    }
}
// aqui mantem o usuario logado e "protege a pg"
function protegePagina() {
    if (!isset($_SESSION['username']) || !isset($_SESSION['tipo'])) {
        header("Location: ../login/login.php");
        exit();
    }
}

?>
