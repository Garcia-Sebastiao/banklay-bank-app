<?php
session_start();
require_once realpath($_SERVER['DOCUMENT_ROOT'] . '/mobile-app/src/php/config/Sql.php');

class TransictionsRepository
{
    public function createTransictions($user_id, $title, $description, $expire_date, $pin, $amount, $type)
    {
        $sql = new Sql;
        $sql->query("INSERT INTO transactions (user_id, transaction_title, transaction_description, expire_date, transaction_pin, transaction_amount, transaction_type) VALUES (:user_id, :transaction_title, :transaction_description, :expire_date, :transaction_pin, :transaction_amount, :transaction_type)");

        $sql->bind(":user_id", $user_id);
        $sql->bind(":transaction_title", $title);
        $sql->bind(":transaction_description", $description);
        $sql->bind(":expire_date", $expire_date);
        $sql->bind(":transaction_pin", $pin);
        $sql->bind(":transaction_amount", $amount);
        $sql->bind(":transaction_type", $type);

        return $sql->execute() ? true : false;
    }

    public function deleteTransiction($id)
    {
        $sql = new Sql;
        $sql->query("DELETE FROM transictions WHERE transiction_id = :transiction_id");
        $sql->bind(":transiction_id", $id);

        return $sql->execute() ? true : false;
    }

    public function updateTransiction($id, $title, $description, $expire_date, $pin, $amount)
    {
        $sql = new Sql;
        $sql->query("UPDATE transictions SET transiction_title = :transiction_title, transiction_description = :transiction_description, expire_date = :expire_date, transiction_pin = :transiction_pin, transiction_amount = :transiction_amount WHERE transiction_id = :transiction_id");

        $sql->bind(":transiction_id", $id);
        $sql->bind(":transiction_title", $title);
        $sql->bind(":transiction_description", $description);
        $sql->bind(":expire_date", $expire_date);
        $sql->bind(":transiction_pin", $pin);
        $sql->bind(":transiction_amount", $amount);

        return $sql->execute() ? true : false;
    }

    public function getTransictionsByUser($user_id)
    {
        $sql = new Sql;
        $sql->query("SELECT * FROM transactions WHERE user_id = :user_id");
        $sql->bind(":user_id", $user_id);
    }

    public function getLastTransictionId()
    {
        $sql = new Sql;
        $sql->query("SELECT transaction_id FROM transactions ORDER BY transaction_id DESC LIMIT 1");

        return $sql->getResult();
    }
    public function getTransactions()
    {
        $sql = new Sql;
        $sql->query("SELECT * FROM transactions WHERE user_id = :user_id ORDER BY transaction_id");

        $sql->bind(":user_id", $_SESSION['user_id']);
        return $sql->getResults();
    }

    public function getRecentTransactions()
    {
        $sql = new Sql;
        $sql->query("SELECT * FROM transactions WHERE user_id = :user_id ORDER BY transaction_id LIMIT 3");

        $sql->bind(":user_id", $_SESSION['user_id']);
        return $sql->getResults();
    }

    public function getTransactionById($id)
    {
        $sql = new Sql;
        $sql->query("SELECT transaction_id, transaction_title, transaction_amount, transaction_pin FROM transactions WHERE transaction_id = :transaction_id");
        $sql->bind(":transaction_id", $id);

        return $sql->getResult();
    }

    public function getById($id)
    {
        $sql = new Sql;
        $sql->query("SELECT * FROM transactions WHERE transaction_id = :transaction_id ORDER BY transaction_id");
        $sql->bind(":transaction_id", $id);

        return $sql->getResult();
    }

    public function setTransactionInactive($id)
    {
        $sql = new Sql;
        $sql->query("UPDATE transactions SET transaction_state = 0 WHERE transaction_id = :transaction_id");
        $sql->bind(":transaction_id", $id);

        return $sql->execute() ? true : false;
    }

    public function updateTransactionType($id)
    {
        $sql = new Sql;
        $sql->query("UPDATE transactions SET transaction_type = :transaction_type WHERE transaction_id = :transaction_id");
        $sql->bind(":transaction_id", $id);
        $sql->bind(":transaction_type", "Recebido");

        return $sql->execute() ? true : false;
    }
}