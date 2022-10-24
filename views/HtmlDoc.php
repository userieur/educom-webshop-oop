<?php
    class HtmlDoc 
    { 

        public function show() { 
           $this->beginDoc(); 
           $this->beginHead(); 
           $this->headContent(); 
           $this->endHead(); 
           $this->beginBody(); 
           $this->bodyContent(); 
           $this->endBody(); 
           $this->endDoc(); 
        }     

        private function beginDoc() {
            echo "<!DOCTYPE html>\n<html>";  
        } 

        private function beginHead() {  
            echo "
    <head>"; 
        }

        protected function headContent() {
            echo "
        <title>Mijn eerste class</title>\n";
        }
        
        private function endHead() {  
            echo "
    </head>";  
        } 
        
        private function beginBody() {  
            echo "
    <body>";  
        } 
        
        protected function bodyContent() {  
            echo    "       <h1>Mijn eerste class</h1>\n";  
        } 
        
        private function endBody() {  
            echo "
    </body>\n";  
        } 
        
        private function endDoc() {  
            echo "</html>\n";  
        }
    }
?>