<?php
    include_once "../views/UpdatedDoc.php";

    $data = array ( 'page' => 'updated', /* other fields */ );
    $view = new UpdatedDoc($data);
    $view  -> show();

?>