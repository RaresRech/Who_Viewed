<?php

class UTILS
{

    function explodeLinesIntoAssocArray($inputString) {
        if(is_array($inputString))
        {
            return;
        }
        $lines = explode("\n", $inputString);
        $assocArray = array();
    
        foreach ($lines as $index => $line) {
            $line = trim($line);
            if (!empty($line)) {
                $assocArray[$index + 1] = $line;
            }
        }
    
        return $assocArray;
    }

}