<?php
    require_once ("../views/HtmlDoc.php");
    require_once ("../Business/basics.php");

    class BasicDoc extends HtmlDoc { 
        
        protected $data;

        public function __construct($myData) {
            $this->data = $myData;
        }

        protected function title() {
            echo"
        <title>My website - " . $this->data['page'] . "</title>";
        }
        private function metaAuthor() {
        }
        private function cssLinks() {
            echo'       
        <link rel="stylesheet" href="../Presentation/stylesheet.css">';
        }
        private function bodyHeader() {
            echo"
        <h1>Basic</h1>";
        }
        private function mainMenu() {
            $page = $this->data['page'];
            echo'
        <ul class="menu">
            <li><a class="' . (($page == "home") ? "active" : "") . '"href="index.php?page=home">Home</a></li>
            <li><a class="' . (($page == "about") ? "active" : "") . '"href="index.php?page=about">About</a></li>
            <li><a class="' . (($page == "contact") ? "active" : "") . '"href="index.php?page=contact">Contact</a></li>
            <li><a class="' . (($page == "webshop") ? "active" : "") . '"href="index.php?page=webshop">Webshop</a></li>
        </ul>';

        }
        private function sessionMenu() {
            $page = $this->data['page'];
            if (!isset($_SESSION)) {
                echo'
        <ul class="menu">
            <li><a class="' . (($page == "registratie") ? "active" : "") . '"href="index.php?page=registratie">Registratie</a></li>
            <li><a class="' . (($page == "login") ? "active" : "") . '"href="index.php?page=login">Login</a></li>
        </ul>';
            } else {
                echo'
        <ul class="menu">
            <li><a class="' . (($page == "userpage") ? "active" : "") . '"href="index.php?page=userpage">UserPage</a></li>
            <li><a class="' . (($page == "loguit") ? "active" : "") . '"href="index.php?page=loguit">Loguit</a></li>
            <li><a class="' . (($page == "cart") ? "active" : "") . '"href="index.php?page=cart">Cart</a></li>
        </ul>';
            }
        }
        protected function mainContent() {
        }
        private function bodyFooter()  {
            echo"
        <footer>
            <p>Copyright &copy; <script>document.write(new Date().getFullYear())</script> Roland Felt</p>
        </footer>";
        }

        // Override function from htmlDoc
        protected function headContent() {
            $this->title();
            $this->metaAuthor();
            $this->cssLinks();
        } 

        // Override function from htmlDoc
        protected function bodyContent() {
            $this->bodyHeader();
            $this->sessionMenu();
            $this->mainMenu();
            $this->mainContent();
            $this->bodyFooter();
        }   

    }
?>