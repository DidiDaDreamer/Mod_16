<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <!--Sweetalert-->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Poppins:400,700&display=swap" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
</head>

<body class="sub_page">
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
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="d-flex ml-auto flex-column flex-lg-row align-items-center">
              <ul class="navbar-nav  ">
                <li class="nav-item active">
                  <a class="nav-link" href="index.php">Página Inicial <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="do.php"> Nossos Jogos </a>
                </li>
                <?php

                if (isset($_SESSION['user'])) {
                  echo '
                      <li class="nav-item">
                          <a class="nav-link" href="user_profile.php">' . $_SESSION['user'] . '</a>
                      </li>
                      <button id="sweetalert" style="border: none; background: none;">
                          <img src="images/logout.png" alt="Logout" style="width: 50px;">
                      </button>
                      <script> 
                    document.getElementById("sweetalert").addEventListener("click", function() {
                      Swal.fire({
                        title: "Estás prestes a sair da tua conta.",
                        text: "Tens a certeza de que te queres desconectar?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Encerrar sessão"
                      }).then((result) => {
                        if (result.isConfirmed) {
                          $.ajax({
                            url: "logout.php",
                            type: "POST",
                            success: function(response) {
                              Swal.fire({
                                title: "Sessão Encerrada.",
                                text: "Esperamos ver-te em breve!.",
                                icon: "success",
                                timer: 2000
                              }).then(() => {
                                window.location.href = "index.php";
                              });
                            }
                          });
                        }
                      });
                    });
                  </script>';
                }
                else
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
  </div>

  <!-- contact section -->

  <section class="contact_section layout_padding">
    <div class="container">

      <div class="heading_container">
        <h2>
          Log-In
        </h2>
      </div>
      <div class="">
        <div class="">
          <div class="row">
            <div class="col-md-9 mx-auto">
              <div class="contact-form">
                <div class="d-flex justify-content-center">

                  <?php
                      if(isset($_SESSION['user']))
                        echo'<center><h4>Já tens uma sessão aberta, para sair clica no icon em cima a direita';
                      else
                        echo'
                            <form method="post" action="login.php">
                            
                              <input type="text" name="name" required
                              style="
                              border-radius:15px;
                              border-width: 1px;
                              border-color: black;
                              width: 350px;"
                              placeholder="Nome Utilisador">
                            </div>

                            <fieldseet>
                            <div class="d-flex justify-content-center">
                              <input type="password" name="pass" id="myInput" required
                              style="
                              border-radius:15px;
                              border-width: 1px;
                              border-color: black;
                              width: 350px;"
                              placeholder="Password">
                            </div>

                            <center>
                              <fieldset><input type="checkbox" value="Mostrar Password" onclick="myFunction()"
                              style="
                              width:30px;
                              ">Mostar Password</fieldset>
                            </center>
                          
                            <div class="d-flex justify-content-center">
                              <a href="register.php">
                              Ainda não tens conta? Clica aqui!
                              </a>
                            </div>

                            <div class="d-flex justify-content-center">
                              <button type="submit" name="login">Jogar Já!</button>
                            </div>

                            </form>';

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
          echo "
          <script>
          Swal.fire({
            icon: 'question',
            title: 'Nenhuma conta encontrada!',
            text: 'Verifica os teus dados e tenta denovo.',
            showConfirmButton: false,
            timer: 2000
          });
          </script>      
          ";
      } else {
          while (mysqli_stmt_fetch($stmt)) 
          {
            echo "
            <script>
            Swal.fire({
              icon: 'success',
              title: 'Conectado Com successo!',
              text: 'Bem-Vind@ de volta!',
              showConfirmButton: false,
              timer: 2000
            }).then(function () {
              window.location.href = 'index.php';
            });
            </script>      
            ";
              $_SESSION['user'] = $name; 
          } 
      }
      mysqli_stmt_close($stmt);
      mysqli_close($conexao);
    }
  
  ?>
  


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- end contact section -->


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
        <!--<div class="col-md-3">
          <div class="info_form ">
            <h5>
              Newsletter
            </h5>
            <form action="">
              <input type="email" placeholder="Enter your email">
              <button>
                Subscribe
              </button>
            </form>
            <div class="social_box">
              <a href="">
                <img src="images/fb.png" alt="">
              </a>
              <a href="">
                <img src="images/twitter.png" alt="">
              </a>
              <a href="">
                <img src="images/linkedin.png" alt="">
              </a>
              <a href="">
                <img src="images/youtube.png" alt="">
              </a>
            </div>
          </div>
        </div>-->
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
  <script type="text/javascript">
    $(".owl-carousel").owlCarousel({
      loop: true,
      margin: 0,
      navText: [],
      center: true,
      autoplay: true,
      autoplayHoverPause: true,
      responsive: {
        0: {
          items: 1
        },
        1000: {
          items: 3
        }
      }
    });
  </script>
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