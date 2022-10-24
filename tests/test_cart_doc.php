<?php
    include_once "../views/CartDoc.php";

    $data = array ( 'page' => 'cart', /* other fields */ );
    $view = new CartDoc($data);
    $view  -> show();

?>