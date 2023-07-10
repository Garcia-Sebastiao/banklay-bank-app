<?php
session_start();

$_SESSION['transiction_id'] = $_GET['valor'];
header("Location: /mobile-app/src/views/system/transactions/qrcode.php");