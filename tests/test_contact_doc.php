<?php
    include_once "../views/ContactDoc.php";

    $data = array ('page' => 'contact', /* other fields */ );
    $view = new ContactDoc($data);
    $view  -> show();

?>