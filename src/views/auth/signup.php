<?php
require_once("../../php/commands/UserCommands.php");

$UserCommands = new UserCommands;
$UserCommands->createAccount();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registre-se</title>
  <link rel="stylesheet" href="./css/signup.css" />
  <link rel="stylesheet" href="../../css/Main.css" />
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

  <header class="auth-header">
    <a href="../../index.html">
      <img src="../../assets/images/blue-logo.svg" alt="" />
    </a>
  </header>

  <main class="auth-section">
    <h2>Criar Conta</h2>

    <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
      <div>
        <label for="">Nome</label>
        <input type="text" name="user_name" value="<?= $UserCommands->getName() ?>" placeholder="Digite seu Nome"
          required />
      </div>

      <div>
        <label for="">Email</label>
        <input type="email" name="user_email" value="<?= $UserCommands->getEmail() ?>" placeholder="Digite seu Email"
          required />
      </div>

      <div>
        <label for="">Senha</label>
        <input type="password" name="user_password" placeholder="Confirme sua senha" required />
      </div>

      <div>
        <label for="">Confirme sua senha</label>
        <input type="password" name="conf_password" placeholder="Confirme sua senha" required />
      </div>

      <div>
        <label for="">Data de nascimento</label>
        <input name="born_date" value="<?= $UserCommands->getBornDate() ?>" type="date" required />
      </div>

      <div>
        <label for="">Telefone</label>
        <input name="user_phone" value="<?= $UserCommands->getPhone() ?>" type="number" placeholder="Digite seu número"
          required />
      </div>

      <div>
        <label for="">Imagem</label>
        <input name="user_image" type="file" />
      </div>
      <button name="signup-btn">Registrar</button>
    </form>

    <span>Já possui uma conta? <a href="./login.php">Login</a>.</span>
  </main>
</body>

</html>