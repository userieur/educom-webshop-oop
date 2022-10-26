<?php
    require_once("Presentation/pagebuilder.php");
    require_once("Business/business.php");
    require_once("Business/utils.php");
    
    session_start();

    // doLogoutUser();

    $data=[];
    $data['page']= getRequestedPage();
    $data = processRequest($data);
    
    showResponsePage($data);

?>