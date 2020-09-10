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
        $configFormUser = LoginForm::getForm();
        $myView = new View("user/login", "front");
        $myView->assign("configFormUser", $configFormUser);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $validator = new Validator();
            $errors = $validator->checkForm($configFormUser, $_POST);
            if (empty($errors)) {
                //cryptage du mot de passe pour qu'il corresponde à la db puis recherche de celui ci
                $_POST['motDePasse'] = sha1($_POST['motDePasse']);
                $userManager = new UtilisateurManager();
                $user = $userManager->findBy($_POST);
                if (count($user) == 1)
                {
                    if($user[0]->getIdRole() != 1)
                    {
                        if(empty($_SESSION['idUtilisateur1']) && empty($_SESSION['token']))
                        {
                            //si un utilisateur est trouvé, sauvegarde de ses éléments de session et initialisation de son token en db
                            $_SESSION['idUtilisateur1'] = $user[0]->getId();
                            $_SESSION['pseudoJoueur1'] = $user[0]->getPseudo();
                            $_SESSION['role'] = $user[0]->getIdRole();
                            $_SESSION['token'] = Token::getToken();
                            $userManager = new UtilisateurManager();
                            $userManager->manageUserToken($_SESSION['idUtilisateur1'],$_SESSION['token']);
                        }
                        else {
                            if ($user[0]->getId() != $_SESSION['idUtilisateur1'])
                            {
                                $_SESSION['idUtilisateur2'] = $user[0]->getId();
                                $_SESSION['pseudoJoueur2'] = $user[0]->getPseudo();
                                $this->redirectTo('Home', 'default');
                            }
                            else
                            {
                                $errors["connecte"] = "Vous êtes déja connecté avec ce compte!";
                                $myView->assign("errors", $errors);
                                //$this->redirectTo('Utilisateur', 'login');
                            }
                        }
                        $this->redirectTo('Home', 'default');
                    }
                    else
                    {
                        $errors["invalide"] = "Vous devez valider votre email avant de vous connecter !";
                        $myView->assign("errors", $errors);
                    }
                }
                else
                {
                    $errors["identifiantsFaux"] = "Adresse email ou mot de passe incorrect !";
                    $myView->assign("errors", $errors);
                }
            }
            else
                $myView->assign("errors", $errors);
        }
    }

    public function registerAction()
    {
        $configFormUser = RegisterForm::getForm();
        $myView = new View("user/register", "front");
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
                $this->sendMailAccountConfirmation($user->getEmail(),$user->getToken(),$user->getPseudo());

                //en attente de validation du mail
                $_SESSION["newUser"] = 1;
                $this->redirectTo("Utilisateur","registerConfirm");
            }
            else
            {
                $myView->assign("errors", $errors);
            }
        }
        $myView->assign("configFormUser", $configFormUser);
    }

    private function sendMailAccountConfirmation($key, $value, $Pseudo)
    {
        $url = URL_HOST.Helper::getUrl("Utilisateur","registerConfirm")."?key=".urlencode($key)."&token=".urlencode($value);
        $configMail = ConfirmAccountMail::getMail($key, $Pseudo,$url);
        $mail = new Mail();
        $mail->sendMail($configMail);
    }

    public function registerConfirmAction()
    {
        if(!empty($_GET['key']) && !empty($_GET['token']))
        {
            //acces a la page avec des paramètres
            //recherche en db d'un utilisateur correspondant à la key(email) et au token

            $requete = new QueryBuilder(Utilisateur::class, 'utilisateur');
            $requete->querySelect(["idUtilisateur","idRole"]);
            $requete->queryFrom();
            $requete->queryWhere("email", "=", htmlspecialchars(urldecode($_GET['key'])));
            $requete->queryWhere("token", "=", htmlspecialchars(urldecode($_GET['token'])));
            $result = $requete->queryGetValue();
            if (!empty($result))
            {
                if ($result["idRole"] == 1)
                {
                    //si un utilisateur est trouvé et que son role est 4, passe le role a 2 en même temps que la réinitialisation de son token
                    $userManager = new UtilisateurManager();
                    $userManager->manageUserToken($result["idUtilisateur"],0,["idRole"=>2]);
                    $message = Message::mailInscriptionSucess();
                    $view = new View("message", "front");
                    $view->assign("message",$message);
                }
                else
                    $this->redirectTo(  "Errors","quatreCentQuatre");
            }
            else
                $this->redirectTo("Errors", "linkNotFound");
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
        $userManager->manageUserToken($_SESSION['idUtilisateur1'],0);
        $_SESSION = null;
        session_destroy();
        $this->redirectTo("Home","default");
    }
    public function logoutGuestAction()
    {
        $_SESSION['idUtilisateur2'] = null;
        $_SESSION['pseudoJoueur2'] = null;
        $this->redirectTo("Home","default");
    }

    public function forgotPasswordAction()
    {
        $configFormUser = ForgotpasswordForm::getForm();
        $myView = new View("user/forgotPassword", "front");
        $myView->assign("configFormUser", $configFormUser);

        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $validator = new Validator();
            $errors = $validator->checkForm($configFormUser, $_POST);
            if (empty($errors))
            {
                $utilisateurManager = new UtilisateurManager();
                $result = $utilisateurManager->getUtilisateur(["id"],[["email", "=", $_POST['email']]]);
                if (!empty($result))
                {
                    $token = Token::getToken();
                    $utilisateurManager->manageUserToken($result["id"],$token);
                    $url = URL_HOST.Helper::getUrl("Utilisateur","newPassword")."?id=".urlencode($result["id"])."&token=".urlencode($token);
                    $configMail = ForgotPasswordMail::getMail($_POST['email'],$url);
                    $mail = new Mail();
                    $mail->sendMail($configMail);
                }
                else
                {
                    $errors["emailNotFound"] = "aucune adresse mail n'a été trouvé";
                    $myView->assign("errors", $errors);
                }

            }
            else
                $myView->assign("errors", $errors);
        }
    }
    public function newPasswordAction()
    {
        $configFormUser = NewPasswordForm::getForm();
        if(!empty($_GET['id']) && !empty($_GET['token']))
        {
            $utilisateurManager = new UtilisateurManager();
            $result = $utilisateurManager->getUtilisateur(["id"],[["id", "=", htmlspecialchars(urldecode($_GET['id']))],["token", "=", htmlspecialchars(urldecode($_GET['token']))]]);
            if (!empty($result))
            {
                $utilisateurManager->manageUserToken($result["id"],0);
                $_SESSION["idPassword"] = $result["id"];
                $myView = new View("user/newPassword", "front");
                $myView->assign("configFormUser", $configFormUser);
            }
            else
            {
                $this->redirectTo("Errors", "linkNotFound");
            }
        }
        else
        {
            if(empty($_SESSION["idPassword"]))
                $this->redirectTo(  "Errors","quatreCentQuatre");
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
                $myView = new View("user/newPassword", "front");
                $myView->assign("configFormUser", $configFormUser);
                $myView->assign("errors", $errors);
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