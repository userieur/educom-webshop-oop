<?php
    require_once("./controllers/PageController.php");
    require_once("./Business/Utils.php");

    class PageModel extends PageController {

        public $page;
        protected $isPost = false;
        public $menu;
        public $errors = array();
        public $genericErr = '';    
        protected $sessionManager;

        public function __construct($copy) {
            if (empty($copy)) {
                // ==> First instance of PageModel
                // $this->sessionManager = new SessionManager();
            } else {
                // ==> Called from the constructor of an extended class.... 
                $this->page = $copy->page;
                $this->isPost = $copy->isPost;
                $this->menu = $copy->menu;
                $this->genericErr = $copy->genericErr;
                $this->sessionManager = $copy->sessionManager; 
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

        // public function createMenu() {
        //     $this->menu['home'] = new MenuItem('home', 'HOME');
        //     if ($this->sessionManger->isUserLoggedIn()) {
        //         $this->menu['logout'] = new MenuItem('logout', 'LOGOUT', 
        //         $this->sessionManager->getLoggedInUser()['name']);
        //     }
        // }
    }