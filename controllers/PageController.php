<?php



    class PageController {
    
        private $model;
   
        public function __construct() {
            $this->model = new PageModel(NULL);
        }

        public function handleRequest() {
            $this->getRequest();
            $this->processRequest();
            $this->showResponse();
        }


        // from client
        private function getRequest() {
            $this->model->getRequestedPage();
        }

        // business flow code
        private function processRequest() {
            switch($this->model->page) {
                case "Login":
                    $this->model = new UserModel
                        ($this->model);

                    $model->validateLogin();
                    if ($model->valid) {
                        $this->model->doLoginUser();
                        $this->model->setPage("home");
                    }
                break;
            }
        }

        // to client: presentatie laag
        private function showResponsePage() {
            $this->model->createMenu();

            switch($this->model->page) {
                case "Home":
                    require_once("views/home_doc.php");
                    $view = new HomeDoc($this->model);
                    break;
            }
            $view->show();
        }
    }