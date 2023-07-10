<?php
session_start();

require_once realpath($_SERVER['DOCUMENT_ROOT'] . '/mobile-app/src/php/common/File.php');
require_once realpath($_SERVER['DOCUMENT_ROOT'] . '/mobile-app/src/php/controllers/UserControllers.php');
require_once realpath($_SERVER['DOCUMENT_ROOT'] . '/mobile-app/src/php/repositories/UserRepository.php');

class UserCommands
{
    private $user_name;
    private $user_email;
    private $user_password;
    private $user_phone;
    private $born_date;
    private $user_image;
    private $account_reference;
    private $account_amount;

    public function getName()
    {
        return $this->user_name;
    }
    public function setName($value)
    {
        $this->user_name = $value;
    }

    public function getEmail()
    {
        return $this->user_email;
    }
    public function setEmail($value)
    {
        $this->user_email = $value;
    }

    public function getPassword()
    {
        return $this->user_password;
    }
    public function setPassword($value)
    {
        $this->user_password = $value;
    }

    public function getPhone()
    {
        return $this->user_phone;
    }
    public function setPhone($value)
    {
        $this->user_phone = $value;
    }

    public function getImage()
    {
        return $this->user_image;
    }
    public function setImage($value)
    {
        $this->user_image = $value;
    }

    public function getBornDate()
    {
        return $this->born_date;
    }
    public function setBornDate($value)
    {
        $this->born_date = $value;
    }

    public function getAmmount()
    {
        return $this->account_amount;
    }
    public function setAmmount($value)
    {
        $this->account_amount = $value;
    }

    public function getAccountReference()
    {
        return $this->account_reference;
    }
    public function setAccountReference($value)
    {
        $this->account_reference = $value;
    }

    public function login()
    {
        $datas = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($_POST['login_btn'])) {
            $this->setEmail($datas['user_email']);
            $this->setPassword($datas['user_password']);

            $UserRepository = new UserRepository();
            $result = $UserRepository->login($this->user_email, $this->user_password);

            if (!$result) {
                $_SESSION['error_message'] = "Email ou senha inválidos";
            } else {
                $_SESSION['user_id'] = $result['user_id'];

                $code = rand(0, 9999);
                header('Location: /mobile-app/src/views/auth/verification.php?verif_code=' . $code);
                $_SESSION['verif_code'] = $code;
            }
        }
    }

    public function setCode()
    {
        if (isset($_POST['set_code'])) {
            $code = filter_input(INPUT_POST, "code", FILTER_SANITIZE_NUMBER_INT);
            $UserRepository = new UserRepository;

            if ($_SESSION['verif_code'] != $code) {
                $_SESSION['error_message'] = "Código de verificação inválido!";
            } else {
                header('Location: /mobile-app/');
                $user = $UserRepository->getUserById($_SESSION['user_id']);

                $_SESSION['user_email'] = $user['user_email'];
                unset($_SESSION['verif_code']);
            }
        }
    }

    public function createAccount()
    {
        $datas = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (isset($_POST['signup-btn'])) {
            $this->setName(ucwords($datas['user_name']));
            $this->setEmail($datas['user_email']);
            $this->setPassword($datas['user_password']);
            $this->setPhone($datas['user_phone']);
            $this->setBornDate($datas['born_date']);

            $image = $_FILES['user_image'];
            $file = new File($image);

            if (!$image['name']) {
                $this->setImage("user.png");
            } else {
                $this->setImage($file->Upload("../../assets/images/uploads/users/"));
            }

            $UserRepository = new UserRepository;
            $UserController = new UserController;

            if ($UserController->validateString($this->user_name)) {
                $_SESSION['error_message'] = "O nome digitado possui algum caractere inválido";
            } else if ($UserController->validateEmail($this->user_email)) {
                $_SESSION['error_message'] = "O email possui um dado inválido";
            } else if ($UserController->validatePhone($this->user_phone)) {
                $_SESSION['error_message'] = "O numero de telefone possui um dado inválido";
            } else if ($UserController->passwordVerify($this->user_password, $this->user_password)) {
            } else {
                if ($UserRepository->getUserByEmail($this->user_email)) {
                    $_SESSION['error_message'] = "Já existe uma conta com esse email";
                } else {
                    if (!$UserRepository->createAccount($this->user_name, $this->user_email, $this->user_password, $this->user_phone, $this->born_date, $this->user_image)) {
                        $_SESSION['error_message'] = "Falha ao criar conta";
                    } else {
                        $_SESSION['success_message'] = "Conta criada com sucesso. Faça Login!";
                    }
                }
            }
        }
    }

    public function updateAccount()
    {
        $datas = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $UserRepository = new UserRepository;

        $user = $UserRepository->getUserById($_SESSION['user_id']);

        $this->setName(ucwords($user['user_name']));
        $this->setEmail($user['user_email']);
        $this->setPhone($user['user_phone']);
        $this->setBornDate($user['born_date']);

        if (isset($_POST['update-btn'])) {
            $this->setName(ucwords($datas['user_name']));
            $this->setEmail($datas['user_email']);
            $this->setPhone($datas['user_phone']);
            $this->setBornDate($datas['born_date']);

            $UserController = new UserController;

            if ($UserController->validateString($this->user_name)) {
                $_SESSION['error_message'] = "O nome digitado possui algum caractere inválido";
            } else if ($UserController->validateEmail($this->user_email)) {
                $_SESSION['error_message'] = "O email possui um dado inválido";
            } else if ($UserController->validatePhone($this->user_phone)) {
                $_SESSION['error_message'] = "O numero de telefone possui um dado inválido";
            } else {
                if ($UserRepository->getUserByEmail($this->user_email) && $user['user_id'] != $_SESSION['user_id']) {
                    $_SESSION['error_message'] = "Já existe uma conta com esse email";
                } else {
                    if (!$UserRepository->updateAccount($this->user_name, $this->user_email, $this->user_phone, $this->born_date, $user['user_id'])) {
                        $_SESSION['error_message'] = "Falha ao atualizar dados da conta!";
                    } else {
                        $_SESSION['success_message'] = "Dados da conta atualizados com sucesso!";
                        $_SESSION['user_email'] = $this->user_email;

                        // header("Location: /mobile-app/src/views/system/profile/profile.php");
                    }
                }
            }
        }
    }

    public function updateImage()
    {
        if (isset($_POST['change_image'])) {
            $UserRepository = new UserRepository;

            $image = $_FILES['user_image'];
            $file = new File($image);

            if (!$image['name']) {
                $this->setImage("user.png");
            } else {
                $this->setImage($file->Upload("../../../assets/images/uploads/users/"));
            }

            if ($UserRepository->updateImage($this->user_image, $_SESSION['user_id'])) {
                $_SESSION['error_message'] = "Falha ao atualizar foto!";
            } else {
                $_SESSION['success_message'] = "Foto atualizada com sucesso!";
            }
        }
    }
}