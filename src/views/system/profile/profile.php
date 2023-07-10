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
    <link rel="stylesheet" href="./css/profile.css" />
    <link rel="stylesheet" href="../../../css/Main.css" />
    <title>QR Code</title>
    <script src="../../../js/qrcodejs/qrcode.min.js"></script>
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
        <section class="profile-section">
            <h2>Perfil</h2>

            <div class="profile-image">
                <img src="../../../assets/images/uploads/users/<?= $user['user_image'] ?>" alt="user image" />
            </div>

            <div class="profile-info">
                <h3>
                    <?= $user['user_name'] ?>
                </h3>
                <span>Email: <span>
                        <?= $user['user_email'] ?>
                    </span></span>
                <span>Telefone: <span>
                        <?= $user['user_phone'] ?>
                    </span></span>

                <a href="./editprofile.php">Editar Dados</a>
            </div>

            <a href="./changephoto.php">Alterar Foto</a>

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
                    <a href="../transactions/transactions.php"><img src="../../../assets/images/transfers.svg"
                            alt="" /></a>
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
                console.log(data)
            })
            .catch(function (error) {
                console.error('Ocorreu um erro:', error);
            });

        let qrCode = new QRCode(document.getElementById("qrcode"), {
            text: "Teste de qr code",
            width: 128,
            height: 128
        });
    </script>
</body>

</html>