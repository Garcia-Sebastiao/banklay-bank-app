<?php

class UserController
{
    public static function validateEmail($email)
    {
        return (
            !preg_match(
                "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix",
                $email
            )
        ) ? true : false;
    }

    public function validateString($string)
    {
        return (
            preg_match(
                "/[\^<,\"@\/\{\}\(\)\*\$%\?=>:\|;#]+/i",
                $string
            )
        ) ? true : false;
    }

    public function validatePhone($phone)
    {
        $padrao = '/^(?:\+244|0)?9[123456]\d{7}$/';
        return (
            !preg_match(
                $padrao,
                $phone
            )
        ) ? true : false;
    }

    public function passwordVerify($password, $confirm_password)
    {
        $count = 0;

        while (isset($password[$count])) {
            $count++;
        }

        if ($count < 6) {
            $_SESSION['error_message'] = "A sua senha precisa ter pelo menos 6 caracteres!";

            return true;
        } else if ($count > 16) {
            $_SESSION['error_message'] = "A sua senha não pode ter mais de 16 caracteres!";

            return true;
        } else if ($password !== $confirm_password) {
            $_SESSION['error_message'] = "As senhas digitadas não são compatíveis. Por favor, tente novamente com senhas válidas!";

            return true;
        }
    }

}