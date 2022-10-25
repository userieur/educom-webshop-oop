<?php
    require_once("Presentation/pagebuilder.php");
    require_once("Business/basics.php");
    
    session_start();

    $data=[];
    $data['page']= getRequestedPage();
    $data = processRequest($data);
    
    showResponsePage($data);

?>