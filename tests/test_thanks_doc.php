<?php
    include_once "../views/ThanksDoc.php";

    $data = array ( 'page' => 'thanks', /* other fields */ );
    $view = new ThanksDoc($data);
    $view  -> show();

?>