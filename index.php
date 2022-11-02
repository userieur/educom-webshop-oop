<?php
    require_once("controllers/PageController.php");
    require_once("data/Crud.php");

    session_start();
    
    $crud = new Crud();
    $pageModel = new PageModel(NULL, $crud);
    $controller = new PageController($pageModel);
    $controller->handleRequest();

    // TO DO
    // Orderknop + order wegschrijven -> niet meer gechecked sinds method update
    // Error-trace | Doen bij CRUD?
    // Test formulieren maken voor contact, registratie, login, updated