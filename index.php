<?php
    require_once("Presentation/pagebuilder.php");
    require_once("Business/business.php");
    require_once("Business/utils.php");
    require_once("controllers/PageController.php");

    session_start();

    $data=[];

    $controller = new PageController();
    $controller->handleRequest();

    $data['page']= getRequestedPage();
    $data = processRequest($data);
    
    showResponsePage($data);

?>