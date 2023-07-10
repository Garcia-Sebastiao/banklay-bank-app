<?php
require_once("../../php/commands/UserCommands.php");
$UserCommands = new UserCommands;
$UserCommands->setCode();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="./css/login.css" />
  <link rel="stylesheet" href="../../css/Main.css" />
</head>

<body>
  <?php
  if (isset($_SESSION['error_message'])) {
    ?>
    <div class="error-message">
      <p>
        <?= $_SESSION['error_message']; ?>
      </p>
    </div>
    <?php
    unset($_SESSION['error_message']);
  }
  ?>

  <header class="auth-header">
    <img src="../../assets/images/blue-logo.svg" alt="" />
  </header>

  <main class="auth-section">
    <h2>Verificar Conta</h2>

    <span>Foi enviado um código de verificação para seu email. Por favor
      verifique sua caixa de entrada.</span>

    <form action="" method="post">
      <input type="number" name="code" placeholder="Digite seu código de verificação" />

      <button name="set_code">Entrar</button>
    </form>
  </main>
</body>

</html>