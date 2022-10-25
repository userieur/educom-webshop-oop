<?php
    require_once ("../views/BasicDoc.php");
    
    class ThanksDoc extends BasicDoc {
    // NOG TE VERPlAATSEN
    function showThankYou($data) {
        foreach($data as $key => $item) {
            switch($key) {
                case 'validForm':
                    break;
                default:
                    $value = $item['value'];
                    $label = $item['label'];
                    echo '<p>' . $label . '</p><br>' . $value;
                    echo '</div>';
                    break;
            }
        }
    }

    }