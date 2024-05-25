<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $name = $_POST["name"];
    $pass = $_POST["pass"];
    $pass2 = md5($pass);
    $conexao = mysqli_connect("localhost", "root", "", "crafter"); // Adicionado uma senha vazia para teste local

    if (!$conexao) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $consulta = "SELECT Username, Password FROM UserAccount WHERE Username=? AND Password=?";
    $stmt = mysqli_prepare($conexao, $consulta);

    mysqli_stmt_bind_param($stmt, "ss", $name, $pass2);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $n_registos = mysqli_stmt_num_rows($stmt);

    if ($n_registos == 0) {
        // MSG DE ERRO
        echo "<script>alert('Dados Inválidos!'); window.location.href= 'login.php';</script>";
    } else {
        while (mysqli_stmt_fetch($stmt)) 
        {
            echo "<script>alert('Logado Com Sucesso'); window.location.href= 'index.php';</script>";
            sleep(1);
            $_SESSION['user'] = $name; // Corrigido para usar a variável correta
            header("Location: index.php");
        exit;
        } 
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conexao);
}
?>
