<?php
session_start();

if (isset($_SESSION['user_email'])) {
  header('Location: /mobile-app/src/views/system/home.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="./css/main.css" />
  <link rel="stylesheet" href="../../css/main.css" />
</head>

<body>
  <main class="main-section">
    <img src="../../assets/images/illustration-1.svg" alt="Ilustração" />

    <div class="main-content">
      <h2>Bank on-the-go with our app</h2>

      <span>Gerencie suas finanças e faça transferências, sem sair de casa.</span>

      <div class="auth-options">
        <a href="./signup.php">Criar conta</a>
        <a href="">
          <img src="../../assets/images/google.svg" alt="Login com google" />
          Cadastro com Google
        </a>
      </div>

      <span>Já possui uma conta? <a href="./login.php">Login</a>.</span>
    </div>
  </main>
</body>

</html>