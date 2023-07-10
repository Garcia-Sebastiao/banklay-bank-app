<?php
require_once realpath($_SERVER['DOCUMENT_ROOT'] . '/mobile-app/src/php/config/Sql.php');

class UserRepository
{
    public function login($email, $password)
    {
        $sql = new Sql;
        $sql->query("SELECT * FROM users WHERE user_email = :user_email AND user_password = :user_password");
        $sql->bind(":user_email", $email);
        $sql->bind(":user_password", $password);

        return $sql->getResult();
    }

    public function createAccount($name, $email, $password, $phone, $bornDate, $image, )
    {
        $sql = new Sql;
        $sql->query("INSERT INTO users (user_name, user_email, user_password, user_phone, born_date, account_reference, user_image) VALUES (:user_name, :user_email, :user_password, :user_phone, :born_date, :account_reference, :user_image)");

        $sql->bind(":user_name", $name);
        $sql->bind(":user_email", $email);
        $sql->bind(":user_password", $password);
        $sql->bind(":user_phone", $phone);
        $sql->bind(":born_date", $bornDate);
        $sql->bind(":user_image", $image);
        $sql->bind(":account_reference", mt_rand(0, 9999));

        return $sql->execute() ? true : false;
    }

    public function getUserByEmail($email)
    {
        $sql = new Sql;
        $sql->query("SELECT * FROM users WHERE user_email = :user_email");
        $sql->bind(":user_email", $email);

        return $sql->getResult();
    }

    public function getAmmoutByAccountReference($reference)
    {
        $sql = new Sql;
        $sql->query("SELECT account_amount FROM users WHERE account_reference = :account_reference");
        $sql->bind(":account_reference", $reference);

        return $sql->getResult();
    }

    public function getUserById($id)
    {
        $sql = new Sql;
        $sql->query("SELECT * FROM users WHERE user_id = :user_id");
        $sql->bind(":user_id", $id);

        return $sql->getResult();
    }

    public function updateAccount($name, $email, $phone, $bornDate, $id)
    {
        $sql = new Sql;
        $sql->query("UPDATE users SET user_name = :user_name, user_email = :user_email, user_phone = :user_phone, born_date = :born_date WHERE user_id = :user_id");

        $sql->bind(":user_name", $name);
        $sql->bind(":user_email", $email);
        $sql->bind(":user_phone", $phone);
        $sql->bind(":born_date", $bornDate);
        $sql->bind(":user_id", $id);

        return $sql->execute() ? true : false;
    }

    public function updateImage($image, $id)
    {
        $sql = new Sql;
        $sql->query("UPDATE users SET user_image = :user_image WHERE user_id = :user_id");
        $sql->bind(":user_image", $image);
        $sql->bind(":user_id", $id);

        return $sql->execute() ? true : false;
    }

    public function updatePassword($password, $id)
    {
        $sql = new Sql;
        $sql->query("UPDATE users SET user_password = :user_password WHERE user_id = :user_id");
        $sql->bind(":user_password", $password);
        $sql->bind(":user_id", $id);

        return $sql->execute() ? true : false;
    }

    public function updateAccountAmount($id, $account_amount)
    {
        $sql = new Sql;
        $sql->query("UPDATE users SET account_amount = :account_amount where user_id = :user_id");
        $sql->bind(":account_amount", $account_amount);
        $sql->bind(":user_id", $id);

        return $sql->execute() ? true : false;
    }
}