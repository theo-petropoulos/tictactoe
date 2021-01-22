<?php
    class gameCase{
        public $state='unplayed';
        public $value='-';

        public function playCase(){
            $this->state='played';
        }

        public function getState(){
            return $this->state;
        }

        public function sendValue($val){
            if($val%2){$this->value='X';}
            else{$this->value='O';}
        }

        public function getValue(){
            return $this->value;
        }
    }
?>