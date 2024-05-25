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
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- Captcha Test -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

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
          
          <img src="images/runing.gif" width="50" height="65">

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="d-flex ml-auto flex-column flex-lg-row align-items-center">
              <ul class="navbar-nav  ">
                <li class="nav-item active">
                  <a class="nav-link" href="index.php">Página Inicial <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="do.php"> Nossos Jogos </a>
                </li>
              </ul>
              <div class="user_option">
                <a href="login.php">
                  <img src="images/user.png" alt="">
                </a>
              </div>
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
          Registar
        </h2>
      </div>
      <div class="">
        <div class="">
          <div class="row">
            <div class="col-md-9 mx-auto">
              <div class="contact-form">
              <form id="myForm" method="post" action="register.php">
                <div class="d-flex justify-content-center">
                  <input type="text" name="nickname" required 
                    style="
                    border-radius:15px;
                    border-width: 1px;
                    border-color: black;
                    width: 350px;"
                    placeholder="Nome Utilisador">
                </div>
                <div class="d-flex justify-content-center">
                  <input type="email" name="email" required 
                    style="
                    border-radius:15px;
                    border-width: 1px;
                    border-color: black;
                    width: 350px;"
                    placeholder="Email Address">
                </div>
                <div class="d-flex justify-content-center">
                  <input type="password" name="pass" required 
                    style="
                    border-radius:15px;
                    border-width: 1px;
                    border-color: black;
                    width: 350px;"
                    placeholder="Password">
                </div>
                <div class="d-flex justify-content-center">
                 <div class="g-recaptcha" data-sitekey="6Lduf-MpAAAAAA5sjUFnDMf66Y4e2TBMas84S-ZG" ></div>
                </div>
                <div class="d-flex justify-content-center">
                  <input type="submit" value="Jogar Já!" name="register"
                    style="
                    border-radius:15px;
                    border-width: 1px;
                    border-color: black;
                    width: 350px;">
                </div>
              </form>
              
              <?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $nick = $_POST["nickname"];
    $mail = $_POST["email"];
    $pass = $_POST["pass"];
    $pass2 = md5($pass);
    $conexao = mysqli_connect("localhost", "root", "", "crafter");

    if (!$conexao) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $errors = array();

    // Check if username or email already exists
    $consulta = "SELECT Email, Username FROM UserAccount WHERE Email = ? OR Username = ?";
    $stmt = mysqli_prepare($conexao, $consulta);
    mysqli_stmt_bind_param($stmt, "ss", $mail, $nick);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_bind_result($stmt, $email, $username);
        while (mysqli_stmt_fetch($stmt)) {
            if ($nick == $username) {
                $errors[] = ["title" => "Nome de Utilisador Já em uso!", "text" => ""];
            } elseif ($mail == $email) {
                $errors[] = ["title" => "Email Já em uso!", "text" => ""];
            }
        }
    }

    // Check password criteria
    if (strlen($pass) < 8 || strlen($pass) > 20 ||
        !preg_match("/[\W]/", $pass) ||
        !preg_match("/[A-Z]/", $pass) ||
        !preg_match("/[a-z]/", $pass) ||
        !preg_match("/[0-9]/", $pass)) {
        $errors[] = [
            "title" => "A password deve conter:",
            "text" => "● Mínimo 8 caracteres,<br>
                       ● Máximo 20 caracteres,<br>
                       ● Inclui um caracter especial,<br>
                       ● Inclui uma maiúscula e uma minúscula,<br>
                       ● Inclui um número."
        ];
    }

    // If there are no errors, insert user into database
    if (empty($errors)) {
        $consulta = "INSERT INTO UserAccount (Email, Username, Password, Perms) VALUES (?, ?, ?, 0)";
        $stmt = mysqli_prepare($conexao, $consulta);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $mail, $nick, $pass2);
            if (mysqli_stmt_execute($stmt)) {
                echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script> 
                Swal.fire({
                  icon: "success",
                  title: "Conta criada com sucesso!",
                  showConfirmButton: false,
                  timer: 2000
                }).then(function () {
                  window.location.href = "login.php";
                });
                </script>';
            } else {
                echo "Erro ao executar a declaração: " . mysqli_error($conexao);
            }
        }
    } else {
        // If there are errors, display them using SweetAlert2
        foreach ($errors as $error) {
            if ($error["title"] == "A password deve conter:") {
                echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script> 
                Swal.fire({
                  icon: "error",
                  title: "A password deve conter:",
                  html: "● Mínimo 8 caracteres,<br>● Máximo 20 caracteres,<br>● Inclui um caracter especial,<br>● Inclui uma maiúscula e uma minúscula,<br>● Inclui um número.",
                  showConfirmButton: false,
                  timer: 4000
                }).then(function () {
                  window.location.href = "register.php";
                });
                </script>';
            } else {
                echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script> 
                Swal.fire({
                  icon: "error",
                  title: "' . $error["title"] . '",
                  text: "' . $error["text"] . '",
                  showConfirmButton: false,
                  timer: 2000
                }).then(function () {
                  window.location.href = "register.php";
                });
                </script>';
            }
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
  <section class="info_section">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="info_contact">
            <h5>
              About Shop
            </h5>
            <div>
              <div class="img-box">
                <img src="images/location-white.png" width="18px" alt="">
              </div>
              <p>
                Address
              </p>
            </div>
            <div>
              <div class="img-box">
                <img src="images/telephone-white.png" width="12px" alt="">
              </div>
              <p>
                +01 1234567890
              </p>
            </div>
            <div>
              <div class="img-box">
                <img src="images/envelope-white.png" width="18px" alt="">
              </div>
              <p>
                demo@gmail.com
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info_info">
            <h5>
              Informations
            </h5>
            <p>
              ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
            </p>
          </div>
        </div>

        <div class="col-md=3">
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
        <div class="col-md-3">
          <div class="info_form">
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
        </div>
      </div>
    </div>
  </section>
  <!-- end info_section -->

  <!-- footer section -->
  <section class="container-fluid footer_section">
    <p>
      &copy; 2020 All Rights Reserved By
      <a href="https://html.design/">Free Html Templates</a>
    </p>
  </section>
  <!-- footer section -->

  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    document.getElementById("myForm").addEventListener("submit", function(event) {
      var response = grecaptcha.getResponse();
      if (response.length === 0) {
        event.preventDefault();
        Swal.fire({
          icon: "error",
          title: "reCaptcha",
          text: "Para criares uma conta tens que verificar o reCaptcha!",
          showConfirmButton: false,
          timer: 4000
        });
      }
    });
  </script>
</body>

</html>
