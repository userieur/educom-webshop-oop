<?php
    include_once "../views/BasicDoc.php";

    $data = array ( 'page' => 'basic', /* other fields */ );
    $view = new BasicDoc($data);
    $view  -> show();

?>