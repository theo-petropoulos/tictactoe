<?php
    $var=file_get_contents('test.txt');
    
    function lookFor($file, $item){
        $counter=0;
        for($i=0;isset($file[$i]);$i++){
            if($file[$i]==$item[0]){
                for($j=0;$j<strlen($item) && isset($file[$i+$j]);$j++){
                    if($file[$i+$j]==$item[$j]){
                        if($j==strlen($item)-1){
                            ++$counter;
                        }
                    }
                }
            }
        }
        return $counter;
    }
    
    echo lookFor($var, 'test');

?>