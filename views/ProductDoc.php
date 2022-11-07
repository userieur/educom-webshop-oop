<?php
    require_once ("BasicDoc.php");
    
    abstract class ProductDoc extends BasicDoc {

        protected function mainContent() {
            $this->showItems();
        }

        function showItems() {
            $items = $this->model->products;
            $class = $this->model->productsClass;
            echo '
            <div class="container">';
            foreach($items as $productId => $info) {
                $id = $productId;
                $name = $info->name;
                $imageurl = $info->imageurl;
                $price = $info->price;
                $description = $info->description;
                $countstring = isset($info->count) ? '<p class="count">Items '.$info->count.'</p>' : "";
                echo '
                <div class="webshop">
                    <img class="'.$class.'"src="public/images/'.$imageurl.'" alt="'.$name.'">
                    <p class="name"><a href="index.php?page=detail&id='.$id.'">'.$name.'</a></p>'.
                    $countstring.'
                    <p class="id">Productnr. = '.$id.'</p>
                    <p class="price">€ '.$price.'</p>
                    <p class="description">'.$description.'</p><br>';
                if ($this->model->menu['allowedToBuy']) {
                    $this->addActionForm(ACTION_ADD_TO_CART, $this->model->page, $name, $id);
                    // if count 
                    $this->addActionForm(ACTION_REMOVE_FROM_CART, $this->model->page, $name, $id);
                }
                echo '</div>';
            }
            if ($this->model->page == 'cart' && $this->model->sessionManager->getCart()) {
                $this->addActionForm(ACTION_ORDER, $this->model->page);
            }
            echo '</div>';
        }
        
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
            if ($action == ACTION_ADD_TO_CART) {$label = 'Add';}
            if ($action == ACTION_REMOVE_FROM_CART) {$label = 'Remove';}
            if ($action == ACTION_ORDER) {$label = 'Order';}
                        echo'
            <input type="submit" value="'.$label.'">
            </form>';
        }



    }