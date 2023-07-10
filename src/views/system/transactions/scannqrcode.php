<?php
session_start();
require_once("../../../php/repositories/UserRepository.php");

$UserRepository = new UserRepository;
$user = $UserRepository->getUserByEmail($_SESSION['user_email']);

if (!isset($_SESSION['user_email'])) {
  header('Location: /mobile-app/');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./css/scannqrcode.css" />
  <link rel="stylesheet" href="../../../css/Main.css" />
  <title>Ler código QR</title>
  <script src="../../../js/zxing/index.js"></script>
</head>

<body>
  <?php
  if (isset($_SESSION['error_message'])) { ?>
    <div class="error-message">
      <p>
        <?= $_SESSION['error_message']; ?>
      </p>
    </div>
  <?php
    unset($_SESSION['error_message']);
  } else if (isset($_SESSION['success_message'])) { ?>
    <div class="success-message">
      <p>
        <?= $_SESSION['success_message']; ?>
      </p>
    </div>
  <?php
    unset($_SESSION['success_message']);
  }
  ?>
  
  <header class="home-header">
    <div class="user-datas">
      <div class="user-image">
        <img src="../../../assets/images/uploads/users/<?= $user['user_image'] ?>" alt="user image" />
      </div>

      <div class="user-info">
        <span>
          <?= $user['user_name'] ?>
        </span>
        <small>
          <?= $user['user_email'] ?>
        </small>
      </div>
    </div>

    <a href="../../../php/commands/LogoutCommand.php">
      <img src="../../../assets/images/logout.svg" alt="" />
    </a>
  </header>

  <main>
    <section class="qrcode-section">
      <h2>Ler dados do QR Code</h2>

      <span> Utilize o scanner para ler o código QR.</span>

      <div class="qr-code">
        <div>
          <video src="" id="videoElement"></video>
        </div>
      </div>
    </section>
  </main>

  <footer>
    <nav>
      <ul>
        <li>
          <a href="../home.php"><img src="../../../assets/images/home.svg" alt="" /></a>
          <span>Inicio</span>
        </li>
        <li>
          <a href="./transactions.php"><img src="../../../assets/images/transfers.svg" alt="" /></a>
          <span>Transações</span>
        </li>

        <li>
          <a class="app" href=""><img src="../../../assets/images/app.svg" alt="" /></a>
        </li>

        <li>
          <a href=""><img src="../../../assets/images/cards.svg" alt="" /></a>
          <span>Cartões</span>
        </li>

        <li>
          <a href=""><img src="../../../assets/images/user.svg" alt="" /></a>
          <span>Conta</span>
        </li>
      </ul>
    </nav>
  </footer>

  <script>
    const codeReader = new ZXing.BrowserQRCodeReader();

    codeReader
      .decodeOnceFromVideoDevice(undefined, "videoElement")
      .then((result) => {
        console.log("Conteúdo do QR Code:", result.text);

        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState === 4 && this.status === 200) {
            let respostaPHP = this.responseText;
            console.log(respostaPHP);
          }
        };

        xmlhttp.open("POST", "../../../php/commands/QRCodeCommands.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("valor=" + encodeURIComponent(result.text));
        window.location.href = "../../../php/commands/QRCodeCommands.php?valor=" + encodeURIComponent(result.text);
      })
      .catch((err) => {
        console.error(err);
      });
  </script>
</body>

</html>