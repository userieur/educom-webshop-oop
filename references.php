<?php
    require_once("./models/PageModel.php");
    require_once("./models/UserModel.php");
    require_once("./models/ShopModel.php");
    require_once("constants.php");
    require_once("session.php");
    require_once("utils.php");
    require_once("data/CrudShop.php");
    require_once("data/CrudUser.php");

    // validations
    foreach (glob("validations/*") as $filename)
    {
        require_once $filename;
    }
