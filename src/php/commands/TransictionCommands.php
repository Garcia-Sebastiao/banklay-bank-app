<?php

require_once realpath($_SERVER['DOCUMENT_ROOT'] . '/mobile-app/src/php/common/File.php');
require_once realpath($_SERVER['DOCUMENT_ROOT'] . '/mobile-app/src/php/controllers/UserControllers.php');
require_once realpath($_SERVER['DOCUMENT_ROOT'] . '/mobile-app/src/php/repositories/TransictionsRepository.php');

class TransictionCommands
{
    private $transiction_title;
    private $transiction_description;
    private $transiction_amount;
    private $expire_date;
    private $transiction_pin;
    private $user_id;

    public function getTitle()
    {
        return $this->transiction_title;
    }
    public function setTitle($value)
    {
        $this->transiction_title = $value;
    }

    public function getDescription()
    {
        return $this->transiction_description;
    }
    public function setDescription($value)
    {
        $this->transiction_description = $value;
    }

    public function getAmount()
    {
        return $this->transiction_amount;
    }
    public function setAmount($value)
    {
        $this->transiction_amount = $value;
    }

    public function getExpireDate()
    {
        return $this->expire_date;
    }
    public function setExpireDate($value)
    {
        $this->expire_date = $value;
    }

    public function getPin()
    {
        return $this->transiction_pin;
    }
    public function setPin($value)
    {
        $this->transiction_pin = $value;
    }

    public function getUserId()
    {
        return $this->user_id;
    }
    public function setUserid($value)
    {
        $this->user_id = $value;
    }

    public function createTransiction()
    {
        $datas = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($_POST['generate_qrcode'])) {
            $this->setTitle($datas['transiction_title']);
            $this->setDescription($datas['transiction_description']);
            $this->setAmount($datas['transiction_amount']);
            $this->setExpireDate($datas['expire_date']);
            $this->setPin($datas['transiction_pin']);
            $this->setUserid($_SESSION['user_id']);

            $TransictionsRepository = new TransictionsRepository;

            if (!$TransictionsRepository->createTransictions($this->user_id, $this->getTitle(), $this->getDescription(), $this->getExpireDate(), $this->getPin(), $this->getAmount(), "Transferido")) {
                $_SESSION['error_message'] = "Falha ao criar transação";
            } else {
                $_SESSION['success_message'] = "Transação criada com sucesso!";
                $_SESSION['transiction_id'] = $TransictionsRepository->getLastTransictionId()['transaction_id'];

                header("Location: /mobile-app/src/views/system/transactions/qrcode.php");
            }
        }
    }
}