<?php

    function play_move($case, $counter){
        $case->playCase();
        $case->sendValue($counter);
    }

    function verify_game($case){
        for($i=0;$i<9;$i++){
            $arr1[]=$case[$i]->getValue();
            $arr2[]=$case[$i]->getValue();
            $arr3[]=$case[$i]->getValue();
        }
    }

?>