<?php
    require_once ("../views/BasicDoc.php");
    
    abstract class FormDoc extends BasicDoc {
        protected function showForm() {
            $this->showFormStart();
            $this->showFormItems();
            $this->showFormEnd();
        }

        private function showFormStart() {
            echo '
            <form method="POST" action="index.php">
                <div class="'.$this->data['form']['css']. '">
                <input type="hidden" id="page" name="page" value="'.$this->data['page'].'">';
        }

        private function showFormItems() {
            foreach($this->data['form'] as $key => $items){
                switch($key) {
                    case 'validForm':
                    case 'css':
                        break;
                    default:
                        $this->showFormItem($key, $items);
                        break;
                }
            }   
        }

        private function showFormItem($key, $items) {
            $this->createLabel($key, $items);
            $this->createInputField($key, $items);
            $this->createSpan($items);
        }

        private function createLabel($key, $items) {
            $type = $items['type'];
            $label = $items['label'];
            switch ($type) {
                case 'text':
                case 'email':
                case 'phone':
                case 'select':
                    echo '
                    <label class="field" for="'.$key.'">'.$label.'</label>';
                    break;
                case 'radio':
                    echo '
                    <p>'.$label.'</p>';
                    break;
                case 'textbox':
                    echo '
                    <label for="'.$key.'">'.$label.'</label><br>';
                    break;
                case 'password':
                    break;
                default:
                    break;
            }
        }

        private function pattern($type) {
            if ($type == 'phone') {
                $output = ' pattern"=[0-9]{2}[0-9]{8}|[0-9]{3}[0-9]{7}" ';
            } else {
                $output = "";
            }
            return $output;
        }

        private function isSelected($value, $option) {
            return (($value == $option) ? "selected" : "");
        }

        private function isChecked($value, $itemtext) {
            return (($value == $itemtext) ? "checked" : "");
        }

        private function createInputField($key, $items) {
            $type = $items['type'];
            $label = $items['label'];
            $placeholder = $items['placeholder'] ?? "";
            $options = $items['options'] ?? "";
            $value = $items['value'] ?? "";
            switch ($type) {
                case 'text':
                case 'email':
                case 'phone':
                    echo '
                    <input type="'.$type.'" id="'.$key.'" name="'.$key.'" '.$this->pattern($type).'value="'.$value.'" placeholder="'.$placeholder.'">';
                    break;
                case 'select':
                    echo '
                    <select required id="'.$key.'" name="'.$key.'" placeholder="...">
                        <option selected value="" disabled>'.$placeholder.'</option>';
                    foreach($options as $option => $itemtext) {
                        echo '
                        <option '.$this->isSelected($value, $option).' value="'.$option.'">'.$itemtext.'</option>';
                    }
                    echo '
                    </select>';
                    break;
                case 'radio':
                    foreach($options as $option => $itemtext) {
                        echo '
                    <input required type="radio" id="'.$option.'" name="'.$key.'" '.$this->isChecked($value, $itemtext).' value="'.$itemtext.'">
                    <label for="'.$option.'">'.$itemtext.'</label>';
                    } 
                    break;
                case 'textbox':
                    echo '
                    <textarea id="'.$key.'" name="'.$key.'" rows="4" cols="50" placeholder="'.$placeholder.'">'.$value.'</textarea>';
                    break;
                case 'password':
                    echo '
                    <label class="field" for="'.$key.'">'.$label.'</label>
                    <input required type="'.$type.'" id="'.$key.'" name="'.$key.'" '.$this->pattern($type).'>';
                    break;
                default:
                    break;
            }
        }

        private function createSpan($items) {
            $error = $items['error'] ?? "";
            echo '
                    <span class="error">'.$error.'</span><br>';
        }

        private function showFormEnd() {
            echo '
                <input type="submit" value="Verstuur">
                </div>
            </form>';
        }
    
    }