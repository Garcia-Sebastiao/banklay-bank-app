<?php
require_once("../../../php/commands/TransictionCommands.php");
require_once("../../../php/repositories/UserRepository.php");

$UserRepository = new UserRepository;
$TransictionCommands = new TransictionCommands;

$user = $UserRepository->getUserByEmail($_SESSION['user_email']);

$TransictionCommands->createTransiction();

if (!isset($_SESSION['user_email'])) {
  header('Location: /mobile-app/');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./css/buyqrcode.css" />
  <link rel="stylesheet" href="../../../css/Main.css" />
  <title>Transferir Dinheiro</title>
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
    <section class="buy-section">
      <h2>Gerar QR Code</h2>

      <span> Gere seu QR code para fazer suas compras rapidamente. </span>

      <form action="" method="POST" class="buy-form">
        <div>
          <label for="bank">Title</label>
          <input type="text" name="transiction_title" value="<?= $TransictionCommands->getTitle() ?>" id="bank"
            placeholder="Nomeie sua transição" required />
        </div>

        <div>
          <label for="bank">Descrição</label>
          <input type="text" name="transiction_description" value="<?= $TransictionCommands->getDescription() ?>"
            id="bank" placeholder="Descreva sua sua transição" required />
        </div>

        <div>
          <label for="amount">Quantia</label>
          <input type="number" name="transiction_amount" value="<?= $TransictionCommands->getAmount() ?>" id="amount"
            placeholder="Digite a quantia" required />
        </div>

        <div>
          <label for="expire_date">Data de validade</label>
          <input type="date" name="expire_date" id="" required />
        </div>

        <div>
          <label for="pin">PIN</label>
          <input type="number" name="transiction_pin" id="pin" value="<?= $TransictionCommands->getPin() ?>"
            placeholder="Digite o pin" required />
        </div>

        <button name="generate_qrcode">Gerar QR</button>
        <a href="./scannqrcode.php">Ler QR Code</a>
      </form>
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
          <a href="./transactions.html"><img src="../../../assets/images/transfers.svg" alt="" /></a>
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
</body>

</html>