<?php
    include_once "../views/WebshopDoc.php";

    $data = array ( 'page' => 'webshop', /* other fields */ );
    $view = new WebshopDoc($data);
    $view  -> show();

?>