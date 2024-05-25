<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <!--Sweet Alert-->
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
                  $conexao = mysqli_connect("localhost", "root", "", "crafter"); // Added an empty password for local testing
                  $admin_perm = 1;
                  $mod_perm = 2;
                  
                  if (!$conexao) {
                      die("Connection failed: " . mysqli_connect_error());
                  }
                  
                  if (isset($_SESSION['user'])) {
                      $username = $_SESSION['user'];
                      $consulta = "SELECT Username, Password FROM UserAccount WHERE Username=? AND (Perms=? OR Perms=?)"; // Parentheses added to group OR conditions
                      $stmt = mysqli_prepare($conexao, $consulta);
                      mysqli_stmt_bind_param($stmt, "sii", $username, $admin_perm, $mod_perm);
                      mysqli_stmt_execute($stmt);
                      mysqli_stmt_store_result($stmt);
                      $n_registos = mysqli_stmt_num_rows($stmt);
                  
                      if ($n_registos == 1) {
                          echo '
                          <li class="nav-item active">
                              <a class="nav-link" href="admin_tools.php">Admin Tools<span class="sr-only">(current)</span></a>
                          </li>';
                      }
                  }
                  ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="do.php"> Nossos Jogos </a>
                                </li>
                                <?php
                // Verifica se existe uma sessão ativa
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
                                showConfirmButton: false,
                                timer: 2000
                              }).then(() => {
                                window.location.reload();
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
    <!-- slider section -->
    <section class=" slider_section position-relative">
      <div class="container">
        <div class="row">
          <div class="col">
            <div class="detail-box">
              <div>
                  <h2 styles="color: black;">
                    Bem-Vindo(a)
                  </h2>
                  <h1>
                    The Crafter
                  </h1>
                  <hr style="border-color: white;">
                  <h3>
                    Com este site vais conseguir descaregar o teu jogo e descubir mais sobre o dos nossos parceiros.
                  </h3>
              </div>
            </div>
          </div>
        </div>
    </section>
  </div>

  <!-- do section -->

  <section class="do_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          Espaço Comentários
        </h2>
        <p>
          Aqui podes ver os comentários feitos pelos utilisadores.
        </p>
      </div>
    </div>
    <br>
      <div class="do_container">

        <div class="img-box">
          <a href="apolo.html">
          <img src="images/Apolo.png" alt="" style="width: 150px;">
          <br>
          <div class="detail-box">
              <center>Apolo</center>
          </div>
              </a>
        </div>
        
        <div class="img-box">
          <img src="images/Exo Invaders.png" alt="" style="width: 150px;">
          <br>
          <div class="detail-box">
              <center>Exo Invaders</center>
          </div>
        </div>
        
        <div class="img-box">
          <img src="images/Run, RX3!.png" alt="" style="width: 150px;">
          <br>
          <div class="detail-box">
              <center>Run RTX!</center>
          </div>
        </div>

        <div class="img-box">
          <img src="images/Soldier'S Redemption.png" alt="" style="width: 150px;">
          <br>
          <div class="detail-box">
              <center>Soldier'S Redemption</center>
          </div>
        </div>

        <div class="img-box">
          <img src="images/The Crafter.png" alt="" style="width: 150px;">
          <br>
          <div class="detail-box">
              <center>The Crafter</center>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- end do section -->

  <!-- who section -->

  <section class="who_section ">
    <div class="container">
      <div class="row">
        <div class="col-md-5">
          <div class="img-box">
            <img src="images/who-img.jpg" alt="">
          </div>
        </div>
        <div class="col-md-7">
          <div class="detail-box">
            <div class="heading_container">
              <h2>
                Quem Somos?
              </h2>
            </div>
            <p>
            Somos desenvolvedores determinados que nos esforçamos ao máximo para 
            proporcionar-te experiências de jogo, atualizações frequentes e fóruns. 
            Trabalhamos incansavelmente para manter uma comunidade vibrante e ativa.
            A nossa missão é a entreajuda entre criadores e utilizadores, 
            para que tenhas informação fresca e objetiva, onde possas partilhar ideias, 
            dicas e sugestões com outros jogadores entusiastas, 
            sem que tenhas que perder tempo a navegar por sites duvidosos ou a procurar informações inúteis. 
            Aqui, podes contar connosco para estarmos sempre ao teu lado, 
            a fazer o máximo para tornar a tua experiência de jogo verdadeiramente apetitosa.
            </p>
            <div>
              <a href="">
                Read More
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end who section -->
                <hr>
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