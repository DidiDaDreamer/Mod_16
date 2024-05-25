<?php
session_start();
$v1 = 0;
$v2 = 0;

$conexao = mysqli_connect("localhost", "root", "", "crafter");
if (!$conexao) {
    die("Connection failed: " . mysqli_connect_error());
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $nick = $_POST["nick"];
    $pass = $_POST["pass"];
    $npass = $_POST["n_pass"];
    $pass2 = md5($pass);
    $npass2 = md5($npass);

    // Check if the provided current password matches the one stored in the database
    $consulta = "SELECT Password FROM UserAccount WHERE Username = ?";
    $stmt = mysqli_prepare($conexao, $consulta);
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['user']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_bind_result($stmt, $db_password);
        mysqli_stmt_fetch($stmt);
        
        // Verify if the provided current password matches the one stored in the database
        if ($pass2 == $db_password) {
            if ($nick != '') {
                // Check if the provided username is already taken
                $consulta = "SELECT Username FROM UserAccount WHERE Username = ?";
                $stmt = mysqli_prepare($conexao, $consulta);
                mysqli_stmt_bind_param($stmt, "s", $nick);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                
                if (mysqli_stmt_num_rows($stmt) > 0) {
                    echo "<script>alert('Esse Nome de Utilisador já está a ser utilizado!'); window.history.back();</script>";
                    exit();
                } else {
                    // Update the username in the database
                    $consulta = "UPDATE UserAccount SET Username = ? WHERE Username = ?";
                    $stmt = mysqli_prepare($conexao, $consulta);
                    mysqli_stmt_bind_param($stmt, "ss", $nick, $_SESSION['user']);
                    mysqli_stmt_execute($stmt);
                    echo "<script>alert('Nome de Utilisador atualizado com sucesso!');window.history.back();</script>";
                    $_SESSION['user'] = $nick;
                    $v1 = 1;
                }
            } 
            if (!(strlen($npass) < 8 || strlen($npass) > 50 || !preg_match("/[\W]/", $npass) || !preg_match("/[A-Z]/", $npass) || !preg_match("/[a-z]/", $npass) || !preg_match("/[0-9]/", $npass))) {
                // Update the password in the database
                $consulta = "UPDATE UserAccount SET Password = ? WHERE Username = ?";
                $stmt = mysqli_prepare($conexao, $consulta);
                mysqli_stmt_bind_param($stmt, "ss", $npass2, $_SESSION['user']);
                mysqli_stmt_execute($stmt);
                echo "<script>alert('Senha atualizada com sucesso!'); window.history.back();</script>";
                $v2 = 1;
                exit();
            }
        } else {
            echo "<script>alert('Senha incorreta');</script>";
            exit();
        }
    } else {
        echo "<script>alert('Erro ao buscar a senha, contacta um ADMIN'); window.location.href= 'index.php';</script>";
        exit();
    }
}
echo'<meta http-equiv="refresh" content="tempo em segundos; URL="index.php"/>';
?>
