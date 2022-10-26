<?php
    require_once ("views/FormsDoc.php");
    
    class RegisterDoc extends FormsDoc {
        protected function title() {
            echo"
        <title>Join us..</title>";
        }
        
        protected function bodyHeader () {
            echo"
        <h1>Halloooooooo</h1>";
        }
        protected function showFormTitle() {
            echo'
        <h3>Doe Invullen</h3>';
        }
    }