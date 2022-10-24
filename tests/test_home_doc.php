<?php
    include_once "../views/HomeDoc.php";

    $data = array ('page' => 'home', /* other fields */ );
    $view = new HomeDoc($data);
    $view  -> show();

?>