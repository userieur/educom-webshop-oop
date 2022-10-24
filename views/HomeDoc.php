<?php
    require_once ("../views/BasicDoc.php");
    
    class HomeDoc extends BasicDoc {
        protected function title() {
            echo"
        <title>Home is where you feel safe</title>";
        }
        
        protected function bodyHeader () {
            echo"
        <h1>Salutaties</h1>";
        }
    
        protected function mainContent() {
            echo'
        <h3>Lorem Ipsum</h3>
            <div>
                <p>"Lorem ipsum dolor sit amet, consectetur <br> adipiscing elit, sed do eiusmod tempor 
                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore 
                eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt
                in culpa qui officia deserunt mollit anim id est laborum."</p>
            </div>';
        }
    }
