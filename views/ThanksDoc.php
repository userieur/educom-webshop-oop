<?php
    require_once ("views/BasicDoc.php");
    
    class ThanksDoc extends BasicDoc {
        protected function title() {
            echo"
        <title>Mannen, jullie worden bedankt!</title>";
        }
        
        protected function bodyHeader () {
            echo"
        <h1>Dankdankdank</h1>";
        }

        protected function mainContent() {
            echo"
        <h3>Je hebt ingevuld:</h3>";
            $this->showThankYou();
        }

        function showThankYou() {
            foreach($this->model->form->formFields as $key => $formItem) {
                $value = $formItem->getValue();
                $label = $formItem->getLabel();
                echo '<p>' . $label . '</p><br>' . $value;
                echo '</div>';
            }
        }
    }
