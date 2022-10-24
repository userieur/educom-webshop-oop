<?php
    include_once "../views/LoginDoc.php";

    $data = array ('page' => 'login', /* other fields */ );
    $view = new LoginDoc($data);
    $view  -> show();

?>