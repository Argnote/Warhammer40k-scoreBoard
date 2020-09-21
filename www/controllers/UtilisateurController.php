<?php

namespace warhammerScoreBoard\controllers;

use warhammerScoreBoard\core\Controller;
use warhammerScoreBoard\core\Helper;
use warhammerScoreBoard\core\QueryBuilder;
use warhammerScoreBoard\core\tools\Message;
use warhammerScoreBoard\core\tools\Token;
use warhammerScoreBoard\core\tools\TransformArrayToSelected;
use warhammerScoreBoard\forms\ForgotpasswordForm;
use warhammerScoreBoard\forms\LoginForm;
use warhammerScoreBoard\forms\NewPasswordForm;
use warhammerScoreBoard\forms\RegisterForm;
use warhammerScoreBoard\forms\updateUtilisateurForm;
use warhammerScoreBoard\getData\GetDataProfilUtilisateur;
use warhammerScoreBoard\getData\GetListDataUtilisateur;
use warhammerScoreBoard\mails\ConfirmAccountMail;
use warhammerScoreBoard\mails\ForgotPasswordMail;
use warhammerScoreBoard\mails\Mail;
use warhammerScoreBoard\managers\UtilisateurManager;
use warhammerScoreBoard\core\Validator;
use warhammerScoreBoard\models\Utilisateur;
use warhammerScoreBoard\core\View;


class UtilisateurController extends Controller
{
    
    public function succesMessageUtilisateurAction()
    {
        if(isset($_SESSION["SuccesMessageUtilisateur"]))
        {
            $view = new View("message", "front");
            $view->assign("message",$_SESSION["SuccesMessageUtilisateur"]);
            unset($_SESSION["SuccesMessageUtilisateur"]);
        }
        else
        {
            $this->redirectTo(  "Errors","quatreCentQuatre");
        }
    }

    public function getListUtilisateurAction()
    {
        Helper::checkAdmin();
        $utilisateurManager = new UtilisateurManager();
        $utilisateurs = $utilisateurManager->getAllUtilisateur();
        $listUtilisateur = GetListDataUtilisateur::getData($utilisateurs);
        $myView = new View("listData","front");
        $myView->assignTitle("Liste des utlisateurs");
        $myView->assign("listData",$listUtilisateur);
    }
    public function getUtilisateurAction()
    {
        Helper::checkConnected();
        $utilisateurManager = new UtilisateurManager();
        $idUtilisateur = $_SESSION["idUtilisateur1"];
        $consultationAdmin = "";
        if($_SESSION["role"] == 3 && isset($_GET["idUtilisateur"]) && is_numeric($_GET["idUtilisateur"]))
        {
            $idUtilisateur = $_GET["idUtilisateur"];
            $consultationAdmin = "?idUtilisateur=".$idUtilisateur;
        }


        $result = $utilisateurManager->getUtilisateurToArray(["*"], [["idUtilisateur","=",$idUtilisateur]]);
        if (!empty($result))
        {
            $profil = GetDataProfilUtilisateur::getData($result);
            $profilView = new View("getData","front");
            $profilView->assignTitle("Consultation du profil");
            $profilView->assign("data",$profil);
            $profilView->assignLink("update",Helper::getUrl("Utilisateur","updateUtilisateur").$consultationAdmin,"Modifier le profil");
            $profilView->assignLink("delete",Helper::getUrl("Utilisateur","deleteUtilisateur").$consultationAdmin,"Supprimer le profil");
        }
        else
        {
            $_SESSION["messageError"] = Message::erreurProfilNotFound();
            $this->redirectTo("Errors", "errorMessage");
        }


    }

    public function updateUtilisateurAction()
    {
        Helper::checkConnected();
        $utilisateurManager = new UtilisateurManager();
        $idUtilisateur = $_SESSION["idUtilisateur1"];
        $role = null;
        $consultationAdmin = "";
        if($_SESSION["role"] == 3 && isset($_GET["idUtilisateur"]) && is_numeric($_GET["idUtilisateur"]))
        {
            $idUtilisateur = $_GET["idUtilisateur"];
            $role = $utilisateurManager->getAllRole();
            $role = TransformArrayToSelected::transformArrayToSelected($role,"idRole","nomRole");
            $consultationAdmin = "?idUtilisateur=".$idUtilisateur;
        }

        $result = $utilisateurManager->getUtilisateurToObject(["*"], [["idUtilisateur","=",$idUtilisateur]]);
        if(empty($result))
        {
            $_SESSION["messageError"] = Message::erreurProfilNotFound();
            $this->redirectTo("Errors", "errorMessage");
        }

        $configFormUser = updateUtilisateurForm::getForm($consultationAdmin,$role,$result);
        $myView = new View("updateData", "front");
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $validator = new Validator();
            $errors = $validator->checkForm($configFormUser ,$_POST);
            if(empty($errors))
            {
                $session = $utilisateurManager->getUtilisateurToObject(["token"],[["idUtilisateur","=",$_SESSION["idUtilisateur1"]]]);
                if ($session->getToken() == $_SESSION["token"]) {
                    //enregistrement du nouvel utilisateur
                    if (isset($_POST["email"])) {
                        $email = $_POST["email"];
                        unset($_POST["email"]);
                    }
                    $user = new Utilisateur();
                    $user = $user->hydrate($_POST);
                    $user->setIdUtilisateur($idUtilisateur);
                    $utilisateurManager->save($user);

                    if (!empty($email)) {
                        $_SESSION["newEmail"] = $email;
                        $url = URL_HOST . Helper::getUrl("Utilisateur", "updateUtilisateur") . "?key=" . urlencode($idUtilisateur) . "&token=" . urlencode($session->getToken());
                        $configMail = ConfirmAccountMail::getMail($email, $user->getPseudo()??$_SESSION['pseudoJoueur1'], $url);
                        $mail = new Mail();
                        $mail->sendMail($configMail);
                        $_SESSION["SuccesMessageUtilisateur"] = Message::changementEmail();
                        $this->redirectTo("Utilisateur", "succesMessageUtilisateur");
                        //en attente de validation du mail
                    }
                    $this->redirectTo("Utilisateur", "getUtilisateur",$consultationAdmin);
                }
                else
                {
                    $_SESSION["messageError"] = Message::erreurTokenSession();
                    $this->redirectTo("Errors", "errorMessage");
                }
            }
            else
            {
                $myView->assign("errors", $errors);
            }
        }

        if(!empty($_GET['key']) && !empty($_GET['token']))
        {
            $result = $utilisateurManager->getUtilisateurToArray(["idUtilisateur"],[["idUtilisateur", "=", htmlspecialchars(urldecode($_GET['key']))],["token", "=", htmlspecialchars(urldecode($_GET['token']))]]);
            if (!empty($result))
            {
                if(isset($_SESSION["newEmail"]))
                {
                    $user = new Utilisateur();
                    $user->setEmail($_SESSION["newEmail"]);
                    $user->setIdUtilisateur($idUtilisateur);
                    $utilisateurManager->save($user);
                    $this->redirectTo("Utilisateur", "getUtilisateur","?idUtilisateur=".urldecode($idUtilisateur));

                }
                else
                {
                    $_SESSION["messageError"] = Message::erreurChangementEmail();
                    $this->redirectTo("Errors", "errorMessage");
                }
            }
            else
            {
                $_SESSION["messageError"] = Message::linkNoValid();
                $this->redirectTo("Errors", "errorMessage");
            }
        }
        $myView->assign("title", "Modification du profil");
        $myView->assign("updateData", $configFormUser);
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
                            $_SESSION['idUtilisateur1'] = $user[0]->getIdUtilisateur();
                            $_SESSION['pseudoJoueur1'] = $user[0]->getPseudo();
                            $_SESSION['role'] = $user[0]->getIdRole();
                            $_SESSION['token'] = Token::getToken();
                            $userManager = new UtilisateurManager();
                            $userManager->manageUserToken($_SESSION['idUtilisateur1'],$_SESSION['token']);
                        }
                        else {
                            if ($user[0]->getIdUtilisateur() != $_SESSION['idUtilisateur1'])
                            {
                                $_SESSION['idUtilisateur2'] = $user[0]->getIdUtilisateur();
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
        Helper::checkDisconnected();
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

                $url = URL_HOST.Helper::getUrl("Utilisateur","registerConfirm")."?key=".urlencode($user->getEmail())."&token=".urlencode($user->getToken());
                $configMail = ConfirmAccountMail::getMail($user->getEmail(), $user->getPseudo(),$url);
                $mail = new Mail();
                $mail->sendMail($configMail);
                //en attente de validation du mail
                $_SESSION["SuccesMessageUtilisateur"] = message::inscriptionSucess();
                $this->redirectTo("Utilisateur","succesMessageUtilisateur");
            }
            else
            {
                $myView->assign("errors", $errors);
            }
        }
        $myView->assign("configFormUser", $configFormUser);
    }


    public function registerConfirmAction()
    {
        Helper::checkDisconnected();
        if(!empty($_GET['key']) && !empty($_GET['token']))
        {
            //acces a la page avec des paramètres
            //recherche en db d'un utilisateur correspondant à la key(email) et au token
            $utilisateurManager = new UtilisateurManager();
            $result = $utilisateurManager->getUtilisateurToArray(["idUtilisateur",DB_PREFIXE."utilisateur.idRole"],[["email", "=", htmlspecialchars(urldecode($_GET['key']))],["token", "=", htmlspecialchars(urldecode($_GET['token']))]]);
            if (!empty($result))
            {
                if ($result["idRole"] == 1)
                {
                    //si un utilisateur est trouvé et que son role est 4, passe le role a 2 en même temps que la réinitialisation de son token
                    $utilisateurManager->manageUserToken($result["idUtilisateur"],0,["idRole"=>2]);
                    $_SESSION["SuccesMessageUtilisateur"] = message::mailInscriptionSucess();
                    $this->redirectTo("Utilisateur","succesMessageUtilisateur");
                }
                else
                    $this->redirectTo(  "Errors","quatreCentQuatre");
            }
            else
            {
                $_SESSION["messageError"] = Message::linkNoValid();
                $this->redirectTo("Errors", "errorMessage");
            }
        }
        else
        {
            $this->redirectTo(  "Errors","quatreCentQuatre");
        }

    }

    public function logoutAction()
    {
        Helper::checkConnected();
        //réinitialisation du token et destruction de la session
        $userManager = new UtilisateurManager();
        $userManager->manageUserToken($_SESSION['idUtilisateur1'],0);
        unset($_SESSION);
        session_destroy();
        $this->redirectTo("Home","default");
    }
    public function logoutGuestAction()
    {
        Helper::checkConnected();
        unset($_SESSION['idUtilisateur2']);
        unset($_SESSION['pseudoJoueur2']);
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
                $utilisateurManager = new UtilisateurManager();
                $result = $utilisateurManager->getUtilisateurToArray(["idUtilisateur"],[["email", "=", $_POST['email']]]);
                if (!empty($result))
                {
                    $token = Token::getToken();
                    $utilisateurManager->manageUserToken($result["idUtilisateur"],$token);
                    $url = URL_HOST.Helper::getUrl("Utilisateur","newPassword")."?id=".urlencode($result["idUtilisateur"])."&token=".urlencode($token);
                    $configMail = ForgotPasswordMail::getMail($_POST['email'],$url);
                    $mail = new Mail();
                    $mail->sendMail($configMail);
                    $_SESSION["SuccesMessageUtilisateur"] = message::sendMailForgotPasswordSucess();
                    $this->redirectTo("Utilisateur","succesMessageUtilisateur");
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
        $utilisateurManager = new UtilisateurManager();
        $configFormUser = NewPasswordForm::getForm();
        $myView = new View("user/newPassword", "front");
        $myView->assign("configFormUser", $configFormUser);

        if(!empty($_GET['id']) && !empty($_GET['token']))
        {
            $result = $utilisateurManager->getUtilisateurToArray(["idUtilisateur"],[["idUtilisateur", "=", htmlspecialchars(urldecode($_GET['id']))],["token", "=", htmlspecialchars(urldecode($_GET['token']))]]);
            if (!empty($result))
            {
                $utilisateurManager->manageUserToken($result["idUtilisateur"],Token::getToken());
                $_SESSION["idUtilisateurNewPassword"] = $result["idUtilisateur"];
            }
            else
            {
                $_SESSION["messageError"] = Message::linkNoValid();
                $this->redirectTo("Errors", "errorMessage");
            }
        }
        elseif(!empty($_SESSION['idUtilisateur1']) && !empty($_SESSION['token']))
        {
            $session = $utilisateurManager->getUtilisateurToArray(["token"],[["idUtilisateur","=",$_SESSION["idUtilisateur1"]]]);
            if ($session["token"] == $_SESSION["token"]) {
                $idUtilisateur = $_SESSION['idUtilisateur1'];
                if ($_SESSION["role"] == 3 && isset($_GET["idUtilisateur"]) && is_numeric($_GET["idUtilisateur"]))
                    $idUtilisateur = $_GET["idUtilisateur"];

                $_SESSION["idUtilisateurNewPassword"] = $idUtilisateur;
            }
            else
            {
                $_SESSION["messageError"] = Message::erreurTokenSession();
                $this->redirectTo("Errors", "errorMessage");
            }

        }
        else
        {
            $this->redirectTo(  "Errors","quatreCentQuatre");
        }

        if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_SESSION["idUtilisateurNewPassword"]))
        {
            $validator = new Validator();
            $errors = $validator->checkForm($configFormUser, $_POST);
            if (empty($errors))
            {
                $user = new Utilisateur();
                $user->setMotDePasse($_POST["motDePasse"]);
                $user->setIdUtilisateur($_SESSION["idUtilisateurNewPassword"]);
                $utilisateurManager->save($user);
                unset($_SESSION["idUtilisateurNewPassword"]);
                $_SESSION["SuccesMessageUtilisateur"] = message::newPasswordSucess();
                $this->redirectTo("Utilisateur","succesMessageUtilisateur");
            }
            else
            {
                $myView->assign("errors", $errors);
            }
        }
    }

    public function deleteUtilisateurAction()
    {
        Helper::checkConnected();
        $utilisateurManager = new UtilisateurManager();
        $session = $utilisateurManager->getUtilisateurToArray(["token"],[["idUtilisateur","=",$_SESSION["idUtilisateur1"]]]);
        if ($session["token"] != $_SESSION["token"])
        {
            $_SESSION["messageError"] = Message::erreurTokenSession();
            $this->redirectTo("Errors", "errorMessage");
        }
        //la supression du compte d'un utilisateur désactive le compte et le déconnecte
        if(!empty($_SESSION["idUtilisateur1"]) && empty($_GET["idUtilisateur"]))
        {
            $utilisateurManager->delete($_SESSION["idUtilisateur1"]);
            unset($_SESSION["role"]);
            unset($_SESSION["idUtilisateur1"]);
            unset($_SESSION["pseudoJoueur1"]);
            unset($_SESSION["token"]);
            $_SESSION["SuccesMessageUtilisateur"] = Message::suppressionCompte();
            $this->redirectTo("Utilisateur", "succesMessageUtilisateur");
        }
        //la suppresion de compte par un admin permet de supprimer le compte en db
        elseif(!empty($_SESSION["role"]) && !empty($_GET["idUtilisateur"]) && $_SESSION["role"] == 3)
        {
            $utilisateurManager->delete($_GET["idUtilisateur"]);
            $this->redirectTo("Utilisateur","getListUtilisateur");
        }
        else
        {
            $_SESSION["messageError"] = Message::erreurSuppressionCompte();
            $this->redirectTo("Errors", "errorMessage");
        }
    }
}