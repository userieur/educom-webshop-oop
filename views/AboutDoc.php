<?php
    require_once ("views/BasicDoc.php");
    
    class AboutDoc extends BasicDoc {
        protected function title() {
            echo"
        <title>About Me</title>";
        }
        
        protected function bodyHeader () {
            echo"
        <h1>Over mij</h1>";
        }
    
        protected function mainContent() {
            echo'
        <h3>Beschrijving</h3>
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