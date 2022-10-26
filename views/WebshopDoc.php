<?php
    require_once ("ProductDoc.php");
    
    class WebshopDoc extends ProductDoc {
        protected function title() {
            echo"
        <title>Webshop</title>";
        }
        
        protected function bodyHeader () {
            echo"
        <h1>Webshop</h1>";
        }
    }