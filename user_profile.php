<?php
session_start();
// Check if session user is not set, redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>The Crafter</title>

    <!-- slider stylesheet -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Poppins:400,700&display=swap"
        rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="css/responsive.css" rel="stylesheet" />
</head>

<body>
    <div class="hero_area">
        <!-- header section strats -->
        <header class="header_section">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg custom_nav-container pt-3">
                    <a class="navbar-brand" href="index.php">
                        <span>
                            The Crafter
                        </span>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <img src="images/runing.gif" width="50" height="65">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="d-flex ml-auto flex-column flex-lg-row align-items-center">
                            <ul class="navbar-nav  ">
                                <?php
                  $conexao = mysqli_connect("localhost", "root", "", "crafter"); // Adicionado uma senha vazia para teste local
                  if (!$conexao) {
                    die("Connection failed: " . mysqli_connect_error());
                  }
                  if(isset($_SESSION['user'])) {
                    $username = $_SESSION['user'];
                    $consulta = "SELECT Username, Password FROM UserAccount WHERE Username=? AND Perms=? OR Perms=?";
                    $stmt = mysqli_prepare($conexao, $consulta);
                    mysqli_stmt_bind_param($stmt, "sii", $username, $admin_perm, $mod_perm); // "s" indica que é uma string
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    $n_registos = mysqli_stmt_num_rows($stmt);
                    if ($n_registos == 1) {
                      echo'
                      <li class="nav-item active">
                        <a class="nav-link" href="admin_tools.php">Admin Tools<span class="sr-only">(current)</span></a>
                      </li>';
                    }
                  }				
                ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="index.php">Página Inicial  </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="do.php"> Nossos Jogos </a>
                                </li>
                                <?php
                // Verifica se existe uma sessão ativa
                if (isset($_SESSION['user'])) {
                    echo '
                        <li class="nav-item">
                            <a class="nav-link" href="user_profile.php">'
                            .$nome = $_SESSION['user'].
                            '</a>
                        </li>
                        <a href="login.php">
                            <img src="images/logout.png" alt="Logout" style="
                            width: 50px;">
                        </a>';
                }else
                    echo '
                    <div class="user_option">
                  <a href="login.php">
                  <img src="images/user.png" alt="Logout">
                  </a>
                </div>';
			?>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <!-- end header section -->
    <!-- slider section -->
    <section class="slider_section position-relative">
        <div class="container">
            <div class="row">
                <div class="col">
                    <?php
                    if(isset($_SESSION['user'])) {
                        $username = $_SESSION['user'];
                        $consulta = "SELECT Username FROM UserAccount";
                                        $stmt = mysqli_prepare($conexao, $consulta);
                                        mysqli_stmt_execute($stmt);
                                        mysqli_stmt_store_result($stmt);
                                        mysqli_stmt_bind_result($stmt, $username);

                        echo '
                        <form method="post" action="user_updater.php">
                        
                        <div class="d-flex justify-content-center">
                        <fieldset style="
                                border: 3px solid #ffffff; /* White border */
                                border-radius: 15px; /* Optional: rounded corners */
                                padding: 20px; /* Optional: Add some padding */
                                width: 600px; /* Width of the fieldset */
                                /*background-color: #ffffff;  Background color */
                            ">
                            <center><h4>Novos Dados:</h4></center>
                            <hr>
                            <br>
                                <div class="d-flex justify-content-center">
                                    <input type="text" name="nick" 
                                        style="
                                            border-radius:7px;
                                            border-width: 1px;
                                            border-color: black;
                                            width: 350px;"
                                        placeholder='.$username.'>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <input type="password" name="n_pass" id="myInput"
                                        style="
                                            border-radius:7px;
                                            border-width: 1px;
                                            border-color: black;
                                            width: 350px;"
                                        placeholder="Nova Password">
                                </div>
                                <center><input type="checkbox" value="Mostrar Password" onclick="myFunction()"
                              style="
                              width:30px;
                              ">Mostar Password
                            </center>
                                <br>  
                                <center><h4>Tua Password Atual:</h4></center><br>
                                
                                <div class="d-flex justify-content-center">
                                <input type="password" name="pass" id="myInput"
                                    style="
                                        border-radius:7px;
                                        border-width: 1px;
                                        border-color: black;
                                        width: 350px;"
                                    placeholder="Password Atual" required>
                            </div>
                                <br>    
                                <div class="d-flex justify-content-center">
                                    <button type="submit" name="update">Atualizar</button>
                                </div>
                                <br>
                                <div class="d-flex justify-content-center">
                                <p>Só a password atual é necessaria! </p>
                                </div>

                            </fieldset>
                            <div>
                        </form>
                        </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
  </div>

  <!-- do section -->

  <!-- info section -->
  <section class="info_section ">
    <div class="container">
      <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-3">
          <div class="info_contact">
            <h5>
              Sobre Nós
            </h5>
            <div>
              <div class="img-box">
                <img src="images/location-white.png" width="18px" alt="">
              </div>
              <p>
                Escola Secundario <br>Dr. Antonio Carvalho Figueredo
              </p>
            </div>
            <hr style="border-color: white;">
            <div>
              <div class="img-box">
                <img src="images/telephone-white.png" width="12px" alt="">
              </div>
              <p>
                9281515790
              </p>
            </div>
            <hr style="border-color: white;">
            <div>
              <div class="img-box">
                <img src="images/envelope-white.png" width="18px" alt="">
              </div>
              <p>
                diogomiguel@gmail.com
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info_insta">
            <h5>
              Instagram
            </h5>
            <div class="insta_container">
              <div>
                <a href="">
                  <div class="insta-box b-1">
                    <img src="images/insta.png" alt="">
                  </div>
                </a>
                <a href="">
                  <div class="insta-box b-2">
                    <img src="images/insta.png" alt="">
                  </div>
                </a>
              </div>

              <div>
                <a href="">
                  <div class="insta-box b-3">
                    <img src="images/insta.png" alt="">
                  </div>
                </a>
                <a href="">
                  <div class="insta-box b-4">
                    <img src="images/insta.png" alt="">
                  </div>
                </a>
              </div>
              <div>
                <a href="">
                  <div class="insta-box b-3">
                    <img src="images/insta.png" alt="">
                  </div>
                </a>
                <a href="">
                  <div class="insta-box b-4">
                    <img src="images/insta.png" alt="">
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end info_section -->


  <!-- footer section -->
  <section class="container-fluid footer_section">
    <p>
      
    </p>
  </section>
  <!-- footer section -->

  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>
  <!-- owl carousel script 
    -->
    <script>
    function myFunction() {
  var x = document.getElementById("myInput");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
  </script>
  <!-- end owl carousel script -->

</body>
</html>