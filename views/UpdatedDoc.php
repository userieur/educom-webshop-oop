<?php
    require_once ("views/BasicDoc.php");
    
    class UpdatedDoc extends BasicDoc {
        protected function title() {
            echo"
        <title>Altijd weer wat nieuws</title>";
        }
        
        protected function bodyHeader () {
            echo"
        <h1>Updated</h1>";
        }

        protected function mainContent() {
            echo"
        <h3>Je hebt je wachtwoord aangepast</h3>";
        }

    }