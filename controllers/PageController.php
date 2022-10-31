<?php
    require_once("./models/PageModel.php");
    require_once("./models/UserModel.php");
    require_once("./models/ShopModel.php");
    require_once("./Business/constants.php");
    require_once("./Business/session.php");
    require_once("./Business/utils.php");
    require_once("./Business/validation.php");
    require_once("./Business/business.php");
    require_once("./Business/data.php");

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

        private function getRequest() {
            $this->model->getRequestedPage();
        }

        private function processRequest() {
            switch ($this->model->page) {
                case 'contact':
                case 'registratie':
                case 'login':
                case 'userpage':
                    $this->processForm();
                    break;
                case 'webshop':
                case 'detail':
                case 'cart':
                    $this->processShop();
                    break;
                case 'loguit':
                    // Moet dit miss nog aanpassen, maar in principe werkt het..
                    $this->model->sessionManager->doLogoutUser();
                    $this->model->page = 'home';
            }
            $this->buildMenu();
        }
  
        private function processForm() {
            // 1. Update current MODEL with extra variables
            $this->model = new UserModel($this->model);

            // 2. Standard empty form with GET-Request
            $this->model->form = Form::getForm($this->model->page);

            // (3a). When POST-request, fill form with VALUES and check for ERRORS
            //// VRAAG: Is er een global mogelijk zoals $this->FORM & $this->VALIDATIONS ipv model->form etc.
            //// OPMERKING: Onderstaand voelt wat houtje touwtje, maar was de 'vlugge oplossing' zodat er een
            //// object Validate gemaakt werd, waarin ik tijdelijk de email kon opslaan voordat ik hem
            //// een connectie met de database laat maken. Kan dat command wat overzichtelijker / andere manier?
            if (Utils::isPostRequest()) {
                $this->model->validations = new Validate();
                $this->model->form = $this->model->validations->validateForm($this->model->form);

                // (3b). When form is VALID: (do ACTION &) SWITCH Page
                if ($this->model->form['validForm']) {
                    switch ($this->model->page) {
                        case 'contact':
                            $this->model->page = 'thanks';
                            break; 
                        case 'registratie':
                            User::storeUser($this->model->form);
                            $this->model->page = 'login';
                            break;
                        case 'login':
                            if ($this->model->authenticateUser()) {
                                $this->model->doLoginUser();
                                $this->model->page = 'home';
                            }
                            break;
                        case 'userpage':
                            if ($this->model->authenticateUser()) {
                                User::updatePassword($this->model->form);
                                $this->model->page = 'updated';
                            }


                            break;
                    }
                }
            }
        }

        private function processShop() {
            // Update current MODEL with extra variables
            $this->model = new ShopModel($this->model);
            $this->model->handleActions();
        }

        private function buildMenu() {
            $this->model->menu['mainPages'] = [HOME, ABOUT, CONTACT, WEBSHOP];
            if ($this->model->sessionManager->isUserLoggedIn()) {
                $this->model->menu['sessionPages'] = [USERPAGE, CART, LOGUIT];
                $this->model->menu['allowedToBuy'] = true;
            } else {
                $this->model->menu['sessionPages'] = [REGISTRATIE, LOGIN];
                $this->model->menu['allowedToBuy'] = false;
            }
        }

        private function showResponsePage() {
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