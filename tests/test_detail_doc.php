<?php
    include_once "../views/DetailDoc.php";

    $data = array ( 'page' => 'detail', /* other fields */ );
    $view = new DetailDoc($data);
    $view  -> show();

?>