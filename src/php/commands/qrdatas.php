<?php

require_once realpath($_SERVER['DOCUMENT_ROOT'] . '/mobile-app/src/php/repositories/TransictionsRepository.php');
$TransictionsRepository = new TransictionsRepository;

$datas = $TransictionsRepository->getTransactionById($_SESSION['transiction_id']);

$results = [$datas];

header('Content-Type: application/json');
echo json_encode($results);