<?php
require_once("../../php/commands/UserCommands.php");
$UserCommands = new UserCommands;
$UserCommands->login();
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
    <a href="/mobile-app/"><img src="../../assets/images/blue-logo.svg" alt="" /></a>
  </header>

  <main class="auth-section">
    <h2>Login</h2>

    <form action="" autocomplete="off" method="post">
      <div>
        <label for="">Email</label>
        <input type="email" name="user_email" value="<?= $UserCommands->getEmail(); ?>"" placeholder=" Digite seu email"
          required />
      </div>

      <div>
        <label for="">Senha</label>
        <input type="password" name="user_password" placeholder="Digite sua senha" required />
      </div>

      <span>Esqueceu sua senha?</span>

      <button name="login_btn">Enviar código</button>
    </form>

    <span>Não possui uma conta? <a href="./signup.php">Registre-se</a>.</span>
  </main>
</body>

</html>