<?php

namespace warhammerScoreBoard\core;

class View
{
    private $template;
    private $view;
    private $data = [];

    public function __construct($view, $template)
    {
        $this->setTemplate($template);
        $this->setView($view);
    }


    public function setTemplate($t)
    {
        $this->template = strtolower(trim($t));
        if (!file_exists("views/templates/" . $this->template . ".tpl.php")) {
            die("Le template n'existe pas");
        }
    }


    public function setView($v)
    {
        $this->view = strtolower(trim($v));
        if (!file_exists("views/".$this->view.".view.php")) {
            die("La vue n'existe pas");
        }
    }


    public function assign($key, $value)
    {
        $this->data[$key] = $value;
    }

    // $this->addModal("carousel", $data);
    public function addModal($modal, $data, array $value = null)
    {
        if (!file_exists("views/modals/".$modal.".mod.php")) {
            die("Le modal n'existe pas!");
        }

        include "views/modals/".$modal.".mod.php";
    }


    public function __destruct()
    {
        extract($this->data);
        include "views/templates/".$this->template.".tpl.php" ;
    }
}
