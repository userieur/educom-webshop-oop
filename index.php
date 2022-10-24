<?php
    require_once("Presentation/pagebuilder.php");
    require_once("Business/basics.php");
    session_start();

    $data=array();
    $data['page']= getRequestedPage();
    
    processRequest($data);
    
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $processed = processRequest($page);
        $page = $processed['page'];
        $data = $processed['data'];
    }
    if ($page == 'loguit') {
        doLogoutUser();
        $page = 'home';
    }
    showResponsePage($page, $pageTitle, $data);

?>