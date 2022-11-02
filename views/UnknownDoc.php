<?php
    require_once ("views/BasicDoc.php");
    
    class UnknownDoc extends BasicDoc {
        protected function title() {
            echo"
        <title>Wat is deze?</title>";
        }
        
        protected function bodyHeader () {
            echo"
        <h1>No way hose</h1>";
        }

        protected function mainContent() {
            echo"
        <h3>404tje gezet G</h3>";
        }

    }