<?php
    require_once ("ProductDoc.php");
    
    class DetailDoc extends ProductDoc {
        protected function title() {
            echo"
        <title>Webshop</title>";
        }
        
        protected function bodyHeader () {
            echo"
        <h1>De Details...</h1>";
        }
    }