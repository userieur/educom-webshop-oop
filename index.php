<?php
    require_once("controllers/PageController.php");

    session_start();
    
    // var_dump($_SESSION);

    $controller = new PageController();
    $controller->handleRequest();

    // TO DO
    // Orderknop + order wegschrijven -> niet meer gechecked sinds method update
    // Error-trace | Doen bij CRUD?
    // Thanks pagina | Unknown pagina | Updated Pagina
    // Test formulieren maken voor contact, registratie, login, updated