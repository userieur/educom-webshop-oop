<?php
    require_once ("ProductDoc.php");
    
    class CartDoc extends ProductDoc {
        protected function title() {
            echo"
        <title>Circle != 0</title>";
        }
        
        protected function bodyHeader () {
            echo"
        <h1>The wheels of the cart go round and round</h1>";
        }
    }