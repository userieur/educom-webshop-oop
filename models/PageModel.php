<?php
    // require_once("session.php");
    // require_once("controllers/PageController.php");
    // require_once("utils.php");

    class PageModel {

        public $page;
        protected $isPost = false;
        public $menu;
        public $sessionManager;
        public $crud;

        public function __construct($copy, $crud) {
            if (empty($copy)) {
                $this->sessionManager = new SessionManager();
                $this->crud = $crud;
            } else {
                $this->page = $copy->page;
                $this->isPost = $copy->isPost;
                $this->menu = $copy->menu;
                $this->sessionManager = $copy->sessionManager;
                $this->crud = $copy->crud;
            }
        }

        public function getRequestedPage() {
            $this->isPost = ($_SERVER['REQUEST_METHOD'] == 'POST');
            if ($this->isPost) {
                $this->setPage(Utils::getPostVar("page", "home"));
            } else {
                $this->setPage(Utils::getUrlVar("page", "home"));
            }
        }

        protected function setPage($newPage) {
            $this->page = $newPage;
        } 

    }