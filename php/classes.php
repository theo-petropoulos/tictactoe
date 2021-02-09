<?php
    require_once('functions.php');

    class gameBox{
        public $state='unplayed';
        public $value='-';

        public function playBox(){
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

    class AI{
        public $memory;
        public $board;

        public function __construct($memory, $board){
            $this->memory=$memory;
            $this->board=$board;
        }
        
        public function playBox(){

        }
    }
?>