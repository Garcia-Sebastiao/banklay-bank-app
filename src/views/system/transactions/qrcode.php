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
  <link rel="stylesheet" href="./css/QRcode.css" />
  <link rel="stylesheet" href="../../../css/main.css" />
  <title>QR Code</title>
  <script src="../../../js/qrcodejs/qrcode.min.js"></script>
</head>

<body>
  <header class="home-header">
    <div class="user-datas">
      <div class="user-image">
        <img style="border-radius: 100%;" src="../../../assets/images/uploads/users/<?= $user['user_image'] ?>"
          alt="user image" />
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
      <h2>Dados do QR Code</h2>

      <span> Utilize este Qr code para suas compras.</span>

      <div class="qrcode-info">
        <div>
          <h4>Id:</h4>
          <span class="transaction_id">-</span>
        </div>

        <div>
          <h4>Título:</h4>
          <span class="transaction_title">-</span>
        </div>

        <div>
          <h4>Quantia:</h4>
          <span class="transaction_amount">-</span>
        </div>
      </div>

      <div class="qr-code">
        <div id="qrcode"></div>
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
    fetch('../../../php/commands/qrdatas.php')
      .then(function (response) {
        console.log(response)
        return response.json();
      })
      .then(function (data) {
        // Manipulando os dados recebidos
        data.map(info => {
          console.log(info);

          document.querySelector(".transaction_id").textContent = info.transaction_id;
          document.querySelector(".transaction_title").textContent = info.transaction_title;
          document.querySelector(".transaction_amount").textContent = info.transaction_amount + " kzs.";

          let qrCode = new QRCode(document.getElementById("qrcode"), {
            text: JSON.stringify(info),
            width: 128,
            height: 128
          });
        });


      })
      .catch(function (error) {
        console.error('Ocorreu um erro:', error);
      });
  </script>
</body>

</html>