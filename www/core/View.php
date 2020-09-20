<?php

namespace warhammerScoreBoard\core;

class View
{
    private $template;
    private $view;
    private $nav;
    private $data = [];

    public function __construct($view, $template)
    {
        $this->setTemplate($template);
        $this->setView($view);
    }
    protected function getNav()
    {
        return $this->nav;
    }

    public function setNav($nav)
    {
        $this->nav = $nav;
    }
    public function setTemplate($t)
    {
        $this->template = trim($t);
        if (!file_exists("views/templates/" . $this->template . ".tpl.php")) {
            die("Le template n'existe pas");
        }
    }


    public function setView($v)
    {
        $this->view = trim($v);
        if (!file_exists("views/".$this->view.".view.php")) {
            die("La vue n'existe pas");
        }
    }


    public function assign($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function assignTitle($title)
    {
        $this->data["title"] = $title;
    }

    public function assignLink($name, $link, $label)
    {
        $this->data[$name."Link"] = $link;
        $this->data[$name."LinkLabel"] = $label;
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
