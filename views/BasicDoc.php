<?php
    require_once ("HtmlDoc.php");

    class BasicDoc extends HtmlDoc { 
        
        // protected $data;

        // public function __construct($myData) {
        //     $this->data = $myData;
        // }

        protected function title() {
            echo"
        <title>My website - " . $this->model['page'] . "</title>";
        }

        private function metaAuthor() {
        }

        private function cssLinks() {
            echo'       
        <link rel="stylesheet" href="Presentation/stylesheet.css">';
        }
        
        protected function bodyHeader() {
            echo"
        <h1>Basic</h1>";
        }

        private function mainMenu() {
            $class = 'menu';
            $this->buildMenuItems($this->model->menu['mainPages'], $this->model->menu['page'], $class);
            var_dump($this->model);
        }
    
        private function sessionMenu() {
            $class = 'menu';
            $this->buildMenuItems($this->model->menu['sessionPages'], $this->model->menu['page'], $class);
        }

        private function buildMenuItems($menu, $currentPage, $class) {
            echo '
            <ul class="'.$class.'">';
            foreach ($menu as $pages) {
                foreach ($pages as $page => $label) {
                    echo'
                    <li><a class="' . (($page == $currentPage) ? "active" : "") . '"href="index.php?page='.$page.'">'.$label.'</a></li>';
                }
            }
            echo '
            </ul>';
        }

        protected function mainContent() {
            'echo ik ben main content';
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