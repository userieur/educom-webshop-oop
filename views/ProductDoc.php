<?php
    require_once ("../views/BasicDoc.php");
    
    abstract class ProductDoc extends BasicDoc {

        
        function addActionForm($action, $page, $name='', $id=0) {
            echo'
            <form method="POST" action="index.php">
            <input type="hidden" id="page" name="page" value="' . $page . '">
            <input type="hidden" id="action" name="action" value="' . $action . '">';
            if (!empty($name)) { echo'
            <input type="hidden" id="name" name="name" value="'.$name.'">';
            }
            if (!empty($id)) { echo'
            <input type="hidden" id="id" name="id" value="'.$id.'">';
            }
            echo'
            <input type="submit" value="Add">
            </form>';
        }

    }