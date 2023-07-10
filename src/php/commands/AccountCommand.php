<?php
require_once realpath($_SERVER['DOCUMENT_ROOT'] . '/mobile-app/src/php/repositories/UserRepository.php');
require_once realpath($_SERVER['DOCUMENT_ROOT'] . '/mobile-app/src/php/repositories/TransictionsRepository.php');

if (!$_SESSION) {
    session_start();
}


class AccountCommand
{
    public function confirmTransaction()
    {
        $pin = filter_input(INPUT_POST, "transaction_pin", FILTER_SANITIZE_NUMBER_INT);

        if (isset($_POST['confirm_transaction'])) {
            $TransictionsRepository = new TransictionsRepository;

            $transaction = $TransictionsRepository->getById($_SESSION['qrcode_transaction_id']);

            if ($transaction['transaction_pin'] != $pin) {
                $_SESSION['error_message'] = "Não foi possível concluir a transferência. PIN inválido";
                header("Location: /mobile-app/src/views/system/transactions/scannqrcode.php");
            } else {
                $UserRepository = new UserRepository;
                $user = $UserRepository->getUserById($transaction['user_id']);
                $myaccount = $UserRepository->getUserById($_SESSION['user_id']);

                $user_account_amount = $user["account_amount"];
                $my_account_amount = $myaccount["account_amount"];

                $actual_amount = $user_account_amount - $transaction['transaction_amount'];
                $my_actual_amount = $my_account_amount + $transaction['transaction_amount'];

                if ($transaction['transaction_state'] == 0) {
                    $_SESSION['error_message'] = "Não foi possível efectuar a transferência. Este qr code já foi utilizado!";

                    header("Location: /mobile-app/src/views/system/home.php");
                } else {
                    if ($user_account_amount < $transaction['transaction_amount']) {
                        $_SESSION['error_message'] = "Não foi possível concluir a transferência. Saldo da conta insuficiente!";

                        header("Location: /mobile-app/src/views/system/home.php");
                    } else {
                        if (!$TransictionsRepository->setTransactionInactive($transaction['transaction_id'])) {
                            $_SESSION['error_message'] = "Não foi possível concluir a transferência.";

                            header("Location: /mobile-app/src/views/system/transactions/scannqrcode.php");
                        } else {
                            if (
                                $UserRepository->updateAccountAmount($transaction['user_id'], $actual_amount) &&
                                $UserRepository->updateAccountAmount($_SESSION['user_id'], $my_actual_amount) && $TransictionsRepository->createTransictions($myaccount['user_id'], $transaction['transaction_title'], $transaction['transaction_description'], $transaction['expire_date'], $transaction['transaction_pin'], $transaction['transaction_amount'], "Recebido")
                            ) {
                                $_SESSION['success_message'] = "Transação realizada com sucesso!";

                                header("Location: /mobile-app/src/views/system/transactions/transactions.php");
                            } else {
                                $_SESSION['error_message'] = "Falha na transação!";
                                header("Location: /mobile-app/src/views/system/home.php");
                            }
                        }
                    }
                }
            }
        }
    }
}