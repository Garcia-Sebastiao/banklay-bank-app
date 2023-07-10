<?php
session_start();

require_once realpath($_SERVER['DOCUMENT_ROOT'] . '/mobile-app/src/php/repositories/UserRepository.php');
require_once realpath($_SERVER['DOCUMENT_ROOT'] . '/mobile-app/src/php/repositories/TransictionsRepository.php');

class QRCodeCommands
{
    public function getQRCodeValues()
    {
        $valorRecebido = $_GET['valor'];
        $results = json_decode($valorRecebido);

        $_SESSION['qrcode_transaction_id'] = $results->transaction_id;
        header("Location: /mobile-app/src/views/system/transactions/insertpin.php");
    }
}

$QRCodeCommands = new QRCodeCommands;
$QRCodeCommands->getQRCodeValues();
