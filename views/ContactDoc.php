<?php
    require_once ("../views/FormsDoc.php");
    require_once ("../Presentation/formbuilder.php");

    class ContactDoc extends FormDoc {
        protected function title() {
            echo"
        <title>All your data are belong to (contact) us</title>";
        }
        
        protected function bodyHeader () {
            echo"
        <h1>Contact Us</h1>";
        }
    
        function getForm() {
            $input = array(
                'sex' => array('type|select','label|Aanhef:','placeholder|Kies', 'options|man:Dhr.|woman:Mevr.')
               ,'fname' => array('type|text','label|Voornaam:','placeholder|Jan', 'checks|validName')
               ,'lname' => array('type|text','label|Achternaam:','placeholder|van der Steen', 'checks|validName')
               ,'email' => array('type|email','label|E-Mail:','placeholder|jan.v.d.steen@provider.com','checks|validEmail')
               ,'phone' => array('type|phone','label|Telefoon:','placeholder|0612345678 / 0101234567','checks|validPhone')
               ,'pref' => array('type|radio','label|Ik word het liefst benaderd via:', 'options|tel:Telefoon|mail:E-Mail')
               ,'story' => array('type|textbox','label|Reden van contact:','placeholder|Vul eens wat in dan!')
            );
            $data = buildFormArray($input);
            return($data);
        }

        protected function mainContent() {
            echo'
        <h3>Doe Invullen</h3>
            <div>
                <p>
                    <b>Algemeen</b><br>
                    Roland wist van jongs af aan al dat hij computers erg leuk vond. Dit is immers de manier hoe hij Engels geleerd heeft;
                    door Command & Conquer te spelen (en TV te kijken). Het heeft hem wel even gekost te leren dat hij programmeren ook leuk vindt,
                    maar hij heeft gelukkig een leuke plek gevonden die hem dat na 30 jaar nog steeds wil leren.<br>
                    <br>
                    Nu maar hopen dat dat goed komt...<br>
                    <br>
                    Stay tuned voor meer dolle avonturen!<br>
                    <br>
                    <b>Hobbies</b><br>
                    <ul class="regular">
                        <li>HTML</li>
                        <li>CSS</li>
                        <li>PHP</li>
                        <li>Apache</li>
                    </ul> 
                </p>
            </div>';
        }
    }