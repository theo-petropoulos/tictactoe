<?php
    //Joue un coup
    function play_move($box, &$counter){
        $box->playBox();
        $box->sendValue($counter);
        ++$counter;
    }

    //Vérifie si la partie est terminée
    function verify_game($box, &$str, $counter){
        //On initilalise la variable "end of game" à 1
        $eog=1;
        //On parcourt les cases, si une case vaut '-' ( non jouée ) alors eog vaut 0
        for($i=0;$i<9;$i++){
            $val[$i]=$box[$i]->getValue();
            if($val[$i]=='-'){
                $eog=0;
            }
        }
        //On vérifie si des lignes de 3 ont été faites, ou si la variable eog vaut 1
        //Si oui, on retourne 1, sinon 0
        if(
            ($val[4]!=='-' && (
                ($val[4]==$val[0] && $val[4]==$val[8]) ||
                ($val[4]==$val[1] && $val[4]==$val[7]) ||
                ($val[4]==$val[2] && $val[4]==$val[6]) ||
                ($val[4]==$val[3] && $val[4]==$val[5]) )
            ) || 
            ($val[0]!='-' && (
                ($val[0]==$val[1] && $val[0]==$val[2]) ||
                ($val[0]==$val[3] && $val[0]==$val[6]) )
            ) || 
            ($val[8]!='-' && (
                ($val[8]==$val[6] && $val[8]==$val[7]) ||
                ($val[8]==$val[2] && $val[8]==$val[5]) )
            ) ||
            $eog==1
        ){
        	if($eog==1){
        		$str.= "DRAW" . PHP_EOL;
            	return 1;
            }
            else{
            	if($counter%2){
            		$str.= "O WON" . PHP_EOL;
                    return 1;
            	}
            	else{
            		$str.= "X WON" . PHP_EOL;
                    return 1;
            	}
            }
        }
        else{
            return 0;
        }
    }

?>