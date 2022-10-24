<?php
    include_once "../views/RegisterDoc.php";

    $data = array ('page' => 'registratie', /* other fields */ );
    $view = new RegisterDoc($data);
    $view  -> show();

?>