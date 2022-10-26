<?php
    require_once ("BasicDoc.php");
    
    abstract class ProductDoc extends BasicDoc {

        protected function mainContent() {
            $this->showItems();
        }

        function showItems() {
            $items = $this->data['products'];
            $class = $this->data['productsClass'];
            echo '
            <div class="container">';
            foreach($items as $productId => $info) {
                $id = $productId;
                $name = $info['name'];
                $imageurl = $info['imageurl'];
                $price = $info['price'];
                $description = $info['description'];
                $countstring = isset($info['count']) ? '<p class="count">Items '.$info['count'].'</p>' : "";
                echo '
                <div class="webshop">
                    <img class="'.$class.'"src="Images/'.$imageurl.'" alt="'.$name.'">
                    <p class="name"><a href="index.php?page=detail&id='.$id.'">'.$name.'</a></p>'.
                    $countstring.'
                    <p class="id">Productnr. = '.$id.'</p>
                    <p class="price">€ '.$price.'</p>
                    <p class="description">'.$description.'</p><br>';
                if ($this->data['allowedToBuy']) {
                    $this->addActionForm(ACTION_ADD_TO_CART, $this->data['page'], $name, $id);
                    $this->addActionForm(ACTION_REMOVE_FROM_CART, $this->data['page'], $name, $id);
                }
                echo '</div>';
            }
            echo '</div>';
        }
        
        function showCart($page, $data) {
            echo '<div class="container">';
            $grandTotal = 0;
            $_SESSION['invoicelines'] = [];
            if ($data) {
                foreach($data as $key => $info) {
                    $id = $key;
                    $name = $info['name'];
                    $imageurl = $info['imageurl'];
                    $price = $info['price'];
                    $description = $info['description'];
                    $count = $_SESSION['cart'][$name];
                    $_SESSION['invoicelines'] += [$name => array()];
                    $_SESSION['invoicelines'][$name] += ['sales_amount' => $count];
                    $_SESSION['invoicelines'][$name] += ['sales_price' => $price];
                    $_SESSION['invoicelines'][$name] += ['article_id' => $id];
                    echo '
                    <div class="webshop">
                        <img class="cart" src="Images/'.$imageurl.'" alt="'.$name.'"><br>
                        <p class="name"><a href="index.php?page=detail&id='.$id.'">'.$name.'</a></p><br>
                        <p class="count">Items'.$count.'</p>
                        <p class="price">€ '.$price.'</p>
                        <p class="subtotal">€ '.$count*$price.'</p>
                        <p class="description">'.$description.'</p><br>';
                    if (isset($_SESSION['user'])) {
                        addToCartForm($page, $name, $id);
                        removeFromCartForm($page, $name, $id);
                    }
                    $grandTotal += ($count*$price);
                    echo '</div>';
                echo '</div>';
                }
                echo '<p class="total">Total = € '.$grandTotal.'</p><br>';
                addActionForm("order", $page);
            } 
             else {
                echo 'cart is empty G';
                unset($_SESSION['invoicelines']);
            }

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