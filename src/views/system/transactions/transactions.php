<?php
require_once("../../../php/repositories/TransictionsRepository.php");
require_once("../../../php/repositories/UserRepository.php");
require_once("../../../php/repositories/TransictionsRepository.php");

$TransictionsRepository = new TransictionsRepository;
$transactions = $TransictionsRepository->getTransactions();

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
  <link rel="stylesheet" href="./css/transactions.css" />
  <link rel="stylesheet" href="../../../css/Main.css" />
  <title>Transações Registradas</title>
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
    <section class="transactions-section">
      <form class="search-form" action="">
        <div>
          <img src="../../../assets/images/search_1.svg" alt="" />
          <input type="search" placeholder="Pesquisar transação" />
        </div>
      </form>

      <div class="transactions-header">
        <h3>Transações Recentes</h3>
      </div>

      <div class="transactions">
        <?php foreach ($transactions as $transaction) { ?>
          <div class="transaction">
            <div class="transaction-image">
              <img src="../../../assets/images/transaction.svg" alt="" />
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
                    href="../../../php/commands/viewqrcode.php?valor=<?= $transaction['transaction_id'] ?>">Ver QR
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
          <a href="../profile/profile.php"><img src="../../../assets/images/user.svg" alt="" /></a>
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
  </script>
</body>

</html>