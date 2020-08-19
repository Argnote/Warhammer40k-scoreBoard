<?php

namespace warhammerScoreBoard\controllers;

use warhammerScoreBoard\core\Controller;
use warhammerScoreBoard\core\Helper;
use warhammerScoreBoard\core\QueryBuilder;
use warhammerScoreBoard\core\tools\Message;
use warhammerScoreBoard\core\tools\Token;
use warhammerScoreBoard\forms\ForgotpasswordForm;
use warhammerScoreBoard\forms\LoginForm;
use warhammerScoreBoard\forms\NewPasswordForm;
use warhammerScoreBoard\forms\RegisterForm;
use warhammerScoreBoard\mails\ConfirmAccountMail;
use warhammerScoreBoard\mails\ForgotPasswordMail;
use warhammerScoreBoard\mails\Mail;
use warhammerScoreBoard\managers\UtilisateurManager;
use warhammerScoreBoard\core\Validator;
use warhammerScoreBoard\models\Utilisateur;
use warhammerScoreBoard\core\View;


class UtilisateurController extends Controller
{
    public function defaultAction()
    {
        $myView = new View("{$_SESSION['dir']}/home", "back");

    }

    public function indexAction()
    {
        $id = ["id"=>$_SESSION['id']];
        $userManager = new UtilisateurManager();
        $user = $userManager->findBy($id);
        $configFromUser = Utilisateur::showUserTable($user);
        $myView = new View("profile", "back");
        $myView->assign("configFromUser", $configFromUser);

    }


    public function listAction(){
        $userManager = new UtilisateurManager();
        $users = $userManager->findAll();
        $configTableUser = Utilisateur::showUserTable($users);

        $myView = new View("admin/user/list", "back");
        $myView->assign("configTableUser", $configTableUser);
    }

    public function updateAction()
    {
        $userManager = new UtilisateurManager();
        $user = $userManager->find($_SESSION['id']);
        if(isset($_POST['role'])):
            $_POST['idHfRole'] = $_POST['role'];
            $route = "/dashboard/permissions";
            else:
            $route = "/profile";
        endif;
        $user = $user->hydrate($_POST);
        $userManager->save($user);

        header("Location: ".$route);
    }


    public function loginAction()
    {
        Helper::checkDisconnected();
        $configFormUser = LoginForm::getForm();
        $myView = new View("login", "front");
        $myView->assign("configFormUser", $configFormUser);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $validator = new Validator();
            $errors = $validator->checkForm($configFormUser, $_POST);
            if (empty($errors)) {
                //cryptage du mot de passe pour qu'il corresponde à la db puis recherche de celui ci
                $_POST['password'] = sha1($_POST['password']);
                $userManager = new UtilisateurManager();
                $user = $userManager->findBy($_POST);
                if (count($user) == 1)
                {
                    if($user[0]->getIdHfRole() != 4)
                    {
                        //si un utilisateur est trouvé, sauvgarde de ses éléments de session et initialisation de son token en db
                        $_SESSION['id'] = $user[0]->getId();
                        $_SESSION['role'] = $user[0]->getIdHfRole();
                        $_SESSION['token'] = Token::getToken();
                        $userManager = new UtilisateurManager();
                        $userManager->manageUserToken($_SESSION['id'],$_SESSION['token']);
                        if ($_SESSION['role'] == 1 ||$_SESSION['role'] == 3) {
                            $_SESSION['dir'] = "admin/";
                        }elseif($_SESSION['role'] == 2){
                            $_SESSION['dir'] = "user/";
                        }
                        $this->redirectTo('User', 'default');
                    }
                    else
                        echo "Vous devez valider votre email avant de vous connecter !";

                } else
                    echo("identifiant ou mot de passe incorrect");
            }
            else
                echo("identifiant ou mot de passe incorrect");
        }
    }

    public function registerAction()
    {
        Helper::checkDisconnected();
        $configFormUser = RegisterForm::getForm();
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $validator = new Validator();
            $errors = $validator->checkForm($configFormUser ,$_POST);
            if(empty($errors))
            {
                //enregistrement du nouvel utilisateur
                $userArray = array_merge($_POST,array("token"=> Token::getToken()));
                $user = new Utilisateur();
                $user = $user->hydrate($userArray);
                $userManager = new UtilisateurManager();
                $userManager->save($user);

                //préparation et envoie du mail de confirmation
//                $url = URL_HOST.Helper::getUrl("User","registerConfirm")."?key=".urlencode($user->getEmail())."&token=".urlencode($user->getToken());
//                $configMail = ConfirmAccountMail::getMail($user->getEmail(), $user->getFirstname(),$url);
//                $mail = new Mail();
//                $mail->sendMail($configMail);
                $this->sendMailAccountConfirmation($user->getEmail(),$user->getToken(),$user->getFirstname());

                //en attente de validation du mail
                $_SESSION["newUser"] = 1;
                $this->redirectTo("User","registerConfirm");
            }
            else
            {
                print_r($errors);
            }
        }
        $myView = new View("register", "front");
        $myView->assign("configFormUser", $configFormUser);
    }

    private function sendMailAccountConfirmation($key, $value, $name)
    {
        $url = URL_HOST.Helper::getUrl("User","registerConfirm")."?key=".urlencode($key)."&token=".urlencode($value);
        $configMail = ConfirmAccountMail::getMail($key, $name,$url);
        $mail = new Mail();
        $mail->sendMail($configMail);
    }
    public function registerConfirmAction()
    {
        Helper::checkDisconnected();
        if(!empty($_GET['key']) && !empty($_GET['token']))
        {
            //acces a la page avec des paramètres
            //recherche en db d'un utilisateur correspondant à la key(email) et au token
            $requete = new QueryBuilder(Utilisateur::class, 'user');
            $requete->querySelect(["id","idHfRole"]);
            $requete->queryWhere("email", "=", htmlspecialchars(urldecode($_GET['key'])));
            $requete->queryWhere("token", "=", htmlspecialchars(urldecode($_GET['token'])));
            $result = $requete->queryGetValue();
            if (!empty($result))
            {
                if ($result["idHfRole"] == 4)
                {
                    //si un utilisateur est trouvé et que son role est 4, passe le role a 2 en même temps que la réinitialisation de son token
                    $userManager = new UtilisateurManager();
                    $userManager->manageUserToken($result["id"],0,["idHfRole"=>2]);
                    $message = Message::mailInscriptionSucess();
                    $view = new View("message", "front");
                    $view->assign("message",$message);
                }
                else
                    die("votre compte est deja validé");
            }
            else
                die("le lien n'est pas bon");
        }
        else
        {
            if (!empty($_SESSION["newUser"]) && $_SESSION["newUser"] == 1)
            {
                //acces à la page sans parametres (juste apres l'inscription quand l'email n'est pas encore validé)
                //new View("registerConfirm", "front");
                $message = message::InscriptionSucess();
                $view = new View("message", "front");
                $view->assign("message",$message);
                unset($_SESSION["newUser"]);
            }
            else
            {
                $this->redirectTo(  "Errors","quatreCentQuatre");
            }
        }

    }

    public function logoutAction()
    {
        //réinitialisation du token et destruction de la session
        $userManager = new UtilisateurManager();
        $userManager->manageUserToken($_SESSION['id'],0);
        session_destroy();
        $this->redirectTo("Home","default");
    }

    public function forgotPasswordAction()
    {
        Helper::checkDisconnected();
        $configFormUser = ForgotpasswordForm::getForm();
        $myView = new View("user/forgotPassword", "front");
        $myView->assign("configFormUser", $configFormUser);

        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $validator = new Validator();
            $errors = $validator->checkForm($configFormUser, $_POST);
            if (empty($errors))
            {
                $requete = new QueryBuilder(Utilisateur::class, 'user');
                $requete->querySelect(["id"]);
                $requete->queryWhere("email", "=", $_POST['email']);
                $result = $requete->queryGetValue();
                if (!empty($result))
                {
                    $token = Token::getToken();
                    $userManager = new UtilisateurManager();
                    $userManager->manageUserToken($result["id"],$token);
                    $url = URL_HOST.Helper::getUrl("User","newPassword")."?id=".urlencode($result["id"])."&token=".urlencode($token);
                    $configMail = ForgotPasswordMail::getMail($_POST['email'],$url);
                    $mail = new Mail();
                    $mail->sendMail($configMail);
                }
            }
            else
                print_r($errors);
        }
    }
    public function newPasswordAction()
    {
        Helper::checkDisconnected();
        $configFormUser = NewPasswordForm::getForm();
        if(!empty($_GET['id']) && !empty($_GET['token']))
        {
            $requete = new QueryBuilder(Utilisateur::class, 'user');
            $requete->querySelect(["id"]);
            $requete->queryWhere("id", "=", htmlspecialchars(urldecode($_GET['id'])));
            $requete->queryWhere("token", "=", htmlspecialchars(urldecode($_GET['token'])));
            $result = $requete->queryGetValue();
            if (!empty($result))
            {
                $myView = new View("user/newPassword", "front");
                $myView->assign("configFormUser", $configFormUser);
                $userManager = new UtilisateurManager();
                $userManager->manageUserToken($result["id"],0);
                $_SESSION["idPassword"] = $result["id"];
            }
            else
            {
                $message = Message::linkNoValid();
                $view = new View("message", "front");
                $view->assign("message",$message);
            }
        }
        else
        {
            if(empty($_SESSION["idPassword"]))
                die("erreurs");
        }

        if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_SESSION["idPassword"]))
        {
            $validator = new Validator();
            $errors = $validator->checkForm($configFormUser, $_POST);
            if (empty($errors))
            {
                $user = new Utilisateur();
                $user->setMotDePasse($_POST["password"]);
                $user->setIdUtilisateur($_SESSION["idPassword"]);
                $userManager = new UtilisateurManager();
                $userManager->save($user);
                unset($_SESSION["idPassword"]);
                $message = message::newPasswordSucess();
                $view = new View("message", "front");
                $view->assign("message",$message);
            }
            else
            {
                print_r($errors);
                $myView = new View("user/newPassword", "front");
                $myView->assign("configFormUser", $configFormUser);
            }
        }
    }

    public function deleteAction()
    {
        //la supression du compte d'un utilisateur désactive le compte et le déconnecte
        if(!empty($_SESSION["id"]))
        {
            $userManager = new UtilisateurManager();
            $userManager->manageUserToken($_SESSION['id'],0,["idHfRole"=>4]);
            session_destroy();
            $this->redirectTo("Home","default");
        }
        //la suppresion de compte par un admin permet de supprimer le compte en db
        if(!empty($_SESSION["role"]) && !empty($_GET["idDelete"]) && $_SESSION['role'] == 1)
        {
            $userManager = new UtilisateurManager();
            $userManager->delete($_GET["idDelete"]);
        }
    }
}