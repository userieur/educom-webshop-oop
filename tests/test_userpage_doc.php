<?php
    include_once "../views/UserpageDoc.php";

    $data = array ( 'page' => 'userpage', /* other fields */ );
    $view = new UserpageDoc($data);
    $view  -> show();

?>