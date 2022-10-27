<?php
    require_once("./models/PageModel.php");
    require_once("./Business/constants.php");
    require_once("./Business/session.php");

    class PageController {
    
        private $model;
   
        public function __construct() {
            $this->model = new PageModel(NULL);
        }

        public function handleRequest() {
            $this->getRequest();
            $this->processRequest();
            $this->showResponsePage();
        }


        // from client
        private function getRequest() {
            $this->model->getRequestedPage();
        }

        // business flow code
        private function processRequests() {
            switch($this->model->page) {
                case "Login":
                    $this->model = new UserModel
                        ($this->model);

                    $this->model->validateLogin();
                    if ($this->model->valid) {
                        $this->model->doLoginUser();
                        $this->model->setPage("home");
                    }
                break;
            }
        }

        private function amphMetamine() {
            // Meta-data for all pages
            $this->model->menu['mainPages'] = [HOME, ABOUT, CONTACT, WEBSHOP];
            if (isUserLoggedIn()) {
                $this->model->menu['sessionPages'] = [USERPAGE, CART, LOGUIT];
                $this->model->menu['allowedToBuy'] = true;
            } else {
                $this->model->menu['sessionPages'] = [REGISTRATIE, LOGIN];
                $this->model->menu['allowedToBuy'] = false;
            }
            // Meta-data for form-pages
            // switch($this->model['page']) {
            //     case 'contact':
            //     case 'registratie':
            //     case 'login':
            //     case 'userpage':
            //         $this->model['form'] = getForm($this->model);
            //         break;
            //     default:
            //         break;
            // }
        }
    

        private function processRequest() {
            $this->amphMetamine();
    
            // switch ($this->model->page) {
            //     case 'contact':
            //     case 'register':
            //     case 'login':
            //     case 'userpage':
            //         // Actions for form-pages    
            //         if (Utils::isPostRequest()) {
            //             $this->model['form'] = validateForm($this->model['form']);
            //         }
            //         break;
            //     case 'webshop':
            //     case 'detail':
            //     case 'cart':
            //         // Actions for product-pages
            //         $products = getItems($this->model);
            //         $this->model['products'] = $products['products'];
            //         $this->model['productsClass'] = $products['class'];
            //         handleActions();
            //         break;
            //     case 'loguit':
            //         doLogoutUser();
            //         $this->model['page'] = 'home';
            //         $this->model = amphMetamine();
            // }
    
            // if (isset($data['form']) && $data['form']['validForm']) {
            //     // Redirects for form-pages, when form is valid
            //     switch ($data['page']) {
            //         case 'contact':
            //             $data['page'] = 'thanks';
            //             $data = amphMetamine($data);
            //             break;
            //         case 'registratie':
            //             storeUser($data);
            //             $data['page'] = 'login';
            //             $data = amphMetamine($data);
            //             break;
            //         case 'login':
            //             doLoginUser($data);
            //             $data['page'] = 'home';
            //             $data = amphMetamine($data);
            //             break;
            //         case 'userpage':
            //             updatePassword($data);
            //             $data['page'] = 'updated';
            //             $data = amphMetamine($data);
            //             break;
                // }
            // }
        }



        

        // to client: presentatie laag

        private function showResponsePage() {
            // $this->model->createMenu();
            $view = NULL;
            switch($this->model->page){
                case 'home':
                    require_once('views/HomeDoc.php');
                    $view = new HomeDoc($this->model);
                    break;
                case 'about':
                    require_once('views/AboutDoc.php');
                    $view = new AboutDoc($this->model);;
                    break;
                case 'contact':
                    require_once('views/ContactDoc.php');
                    $view = new ContactDoc($this->model);
                    break;
                case 'registratie':
                    require_once('views/RegisterDoc.php');
                    $view = new RegisterDoc($this->model);
                    break;
                case 'thanks':
                    require_once('views/ThanksDoc.php');
                    $view = new ThanksDoc($this->model);
                    break;
                case 'login':
                    require_once('views/LoginDoc.php');
                    $view = new LoginDoc($this->model);
                    break;
                case 'userpage':
                    require_once('views/UserpageDoc.php');
                    $view = new UserpageDoc($this->model);
                    break;
                case 'updated':
                    require_once('views/UpdatedDoc.php');
                    $view = new UpdatedDoc($this->model);
                    break;
                case 'webshop':
                    require_once('views/WebshopDoc.php');
                    $view = new WebshopDoc($this->model);
                    break;
                case 'detail':
                    require_once('views/DetailDoc.php');
                    $view = new DetailDoc($this->model);
                    break;
                case 'cart':
                    require_once('views/CartDoc.php');
                    $view = new CartDoc($this->model);
                    break;
                default:
                    require_once('views/HomeDoc.php');
                    $view = new HomeDoc($this->model);
                    break;
                    // require_once('views/UnknownPage.php');
                    // $view = new UnknownPage($this->model);
                    // break;
            }
            $view->show();
        }

    }