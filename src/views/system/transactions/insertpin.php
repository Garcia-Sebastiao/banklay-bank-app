<?php

require_once("../../../php/repositories/UserRepository.php");

require_once("../../../php/repositories/TransictionsRepository.php");
require_once("../../../php/commands/AccountCommand.php");

$UserRepository = new UserRepository;
$TransictionsRepository = new TransictionsRepository;

$transition = $TransictionsRepository->getById($_SESSION['qrcode_transaction_id']);
$user = $UserRepository->getUserByEmail($_SESSION['user_email']);

$AccountCommand = new AccountCommand;
$AccountCommand->confirmTransaction();

if (!isset($_SESSION['user_email'])) {
    header('Location: /mobile-app/');
}

if (!$transition) {
    $_SESSION['error_message'] = "QR Code Inválido. Não existe nenhuma transação com este QR Code.";
    header("Location: /mobile-app/src/views/system/transactions/scannqrcode.php");
}

if ($transition['user_id'] == $_SESSION['user_id']) {
    $_SESSION['error_message'] = "Você não pode transferir dinheiro para si mesmo.";
    
    header("Location: /mobile-app/src/views/system/home.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/insertpin.css" />
    <link rel="stylesheet" href="../../../css/Main.css" />
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
            <h2>Confirmar Transferênia</h2>

            <span>Serão transferidos para a sua conta
                <?= $transition['transaction_amount'] ?> kzs
            </span>

            <form action="" method="POST">
                <input type="number" name="transaction_pin">
                <button name="confirm_transaction">Confirmar</button>
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

                    // const arrayString = `[${info.transaction_id}, ${info.transaction_title}, ${info.transaction_amount}, ${info.transaction_pin}, ${info.user_id} ]`;
                    // console.log(arrayString)
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