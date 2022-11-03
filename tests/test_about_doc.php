<?php
    include_once "../views/AboutDoc.php";

    $data = array ('page' => 'about', /* other fields */ );
    $view = new AboutDoc($data);
    $view  -> show();
