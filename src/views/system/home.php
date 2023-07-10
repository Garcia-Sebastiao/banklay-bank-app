<?php
require_once("../../php/repositories/UserRepository.php");
require_once("../../php/repositories/TransictionsRepository.php");

$TransictionsRepository = new TransictionsRepository;
$transactions = $TransictionsRepository->getTransactions();

$UserRepository = new UserRepository;
$user = $UserRepository->getUserByEmail($_SESSION['user_email']);

if (!$_SESSION) {
  session_start();
}

if (!isset($_SESSION['user_email'])) {
  header('Location: /mobile-app/');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./css/Home1.css" />
  <link rel="stylesheet" href="../../css/Main.css" />
  <title>Banklay</title>
</head>

<body>
  <?php
  if (isset($_SESSION['error_message'])) {
    echo "<div class='error-message'> <p> " . $_SESSION['error_message'] . "</div>";
    unset($_SESSION['error_message']);
  } else if (isset($_SESSION['success_message'])) {
    echo "<div class='success-message'> <p> " . $_SESSION['success_message'] . "</div>";
    unset($_SESSION['success_message']);
  }
  ?>

  <header class="home-header">
    <div class="user-datas">
      <div class="user-image">
        <img style="border-radius: 100%;" src="../../assets/images/uploads/users/<?= $user['user_image'] ?>"
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

    <a href="../../php/commands/LogoutCommand.php">
      <img src="../../assets/images/logout.svg" alt="" />
    </a>
  </header>

  <main>
    <section class="card-section">
      <div class="slide-container">
        <div class="credit-card slide">
          <img class="vetor" src="../../assets/images/vetor-1.svg" alt="" />

          <div class="card-head">
            <h3>Saldo:</h3>

            <img src="../../assets/images/Layer_1.svg" alt="" />
          </div>

          <div class="card-body">
            <h2>kzs
              <?= $user['account_amount'] ?>
            </h2>
          </div>

          <div class="card-foot">
            <img src="../../assets/images/visa.svg" alt="" />

            <span>
              <?= $user['account_reference'] ?>
            </span>
          </div>
        </div>

        <div class="credit-card-back slide">
          <img class="vetor" src="../../assets/images/vetor-1.svg" alt="" />
          <div class="creditb-header">
            <small>Apenas uso digital</small>
            <small>AO 0057</small>
          </div>

          <div class="creditb-blackrow"></div>

          <div class="creditb-desc">
            <span>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Alias
              beatae quibusdam aliquid.</span>

            <div>
              <img src="../../assets/images/logo.svg" alt="" />
            </div>
          </div>
        </div>
      </div>

      <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
      <a class="next" onclick="changeSlide(1)">&#10095;</a>\
    </section>

    <section class="options-section">
      <ul>
        <li>
          <a href="./transactions/buyqrcode.php">
            <img src="../../assets/images/enviar.svg" alt="" />
          </a>
          <small>Enviar</small>
        </li>

        <li>
          <a href="./transactions/scannqrcode.php">
            <img src="../../assets/images/receber.svg" alt="" />
          </a>
          <small>Receber</small>
        </li>

        <li>
          <a href="./transactions/buyqrcode.php">
            <img src="../../assets/images/buy.svg" alt="" />
          </a>
          <small>Comprar</small>
        </li>

        <li>
          <a href="">
            <img src="../../assets/images/bloquear.svg" alt="" />
          </a>
          <small>Bloquear</small>
        </li>
      </ul>
    </section>

    <section class="transactions-section">
      <div class="transactions-header">
        <h3>Transações Recentes</h3>

        <a href="./transactions/transactions.php">Ver todas</a>
      </div>

      <div class="transactions">
        <?php foreach ($transactions as $transaction) { ?>
          <div class="transaction">
            <div class="transaction-image">
              <img src="../../assets/images/transaction.svg" alt="" />
            </div>

            <div class="transaction-desc">
              <div>
                <h3>
                  <?= $transaction['transaction_title'] ?>
                </h3>
                <small class="date">
                  <?= $transaction['create_date'] ?>
                </small>

                <small style="color: <?= $transaction['transaction_state'] == 1 ? 'rgb(63, 211, 73)' : '#db1818' ?>">
                  <?= $transaction['transaction_state'] == 1 ? 'Disponível' : 'Usado' ?>
                </small>
              </div>

              <span style="display: flex; flex-direction: column; gap: 5px; font-family: rubikSemiBold"
                class="<?= $transaction['transaction_type'] == "Transferido" ? 'negative' : 'positive' ?>">
                <?= $transaction['transaction_type'] == "Transferido" ? '-' : '+' ?>
                <?= $transaction['transaction_amount'] ?> kzs
                <small><a style="color: #000;"
                    href="../../php/commands/viewqrcode.php?valor=<?= $transaction['transaction_id'] ?>">Ver QR
                    Code</a></small>
              </span>
            </div>
          </div>
        <?php } ?>
      </div>
    </section>
  </main>

  <footer>
    <nav>
      <ul>
        <li>
          <a href="./home.php"><img src="../../assets/images/home.svg" alt="" /></a>
          <span>Inicio</span>
        </li>
        <li>
          <a href="./transactions/transactions.php"><img src="../../assets/images/transfers.svg" alt="" /></a>
          <span>Transações</span>
        </li>

        <li>
          <a class="app" href=""><img src="../../assets/images/app.svg" alt="" /></a>
        </li>

        <li>
          <a href=""><img src="../../assets/images/cards.svg" alt="" /></a>
          <span>Cartões</span>
        </li>

        <li>
          <a href="./profile/profile.php"><img src="../../assets/images/user.svg" alt="" /></a>
          <span>Conta</span>
        </li>
      </ul>
    </nav>
  </footer>
  <script>
    const date = document.querySelector(".date");

    const dateObj = new Date(date.textContent);

    const day = dateObj.getDate();
    const mounth = dateObj.getMonth();

    let mesesEmExtenso = [
      "janeiro", "fevereiro", "março", "abril", "maio", "junho",
      "julho", "agosto", "setembro", "outubro", "novembro", "dezembro"
    ];

    const mes = mesesEmExtenso[mounth];

    date.textContent = day + " de " + mes + " de " + dateObj.getFullYear();

    let currentSlide = 0;
    let slides = document.getElementsByClassName("slide");

    function showSlide(n) {
      if (n >= slides.length) {
        currentSlide = 0;
      } else if (n < 0) {
        currentSlide = slides.length - 1;
      } else {
        currentSlide = n;
      }

      let slideContainer = document.querySelector(".slide-container");
      slideContainer.style.transform = "translateX(" + (-currentSlide * 100) + "%)";
    }

    function changeSlide(n) {
      showSlide(currentSlide + n);
    }

    window.onload = function () {
      showSlide(0);
    };
  </script>
</body>

</html>