<?php
    require_once ("views/FormsDoc.php");

    class UserpageDoc extends FormsDoc {
        protected function title() {
            echo"
        <title>All your data are belong to (contact) us</title>";
        }
        
        protected function bodyHeader () {
            echo"
        <h1>WW aanpasseeeeen</h1>";
        }
        protected function showFormTitle() {
            echo'
        <h3>Doe Invullen</h3>';
        }
    }