<?php

class telephone {

    public function checkFormatNum($num) {
        $paterneFR = '/^0[1-9]([ .-]?[0-9]{2}){4}$/';
        $paterneEN = '/^0[1-9][0-9]*$/';
        $paterneDE ='/^(\s?0|\d{3,5}\s?){1,2}\d{5,6}$/';

        if(preg_match($paterneFR,$num)||preg_match($paterneEN,$num)||preg_match($paterneDE,$num))
            return true;
        else 
            return false;

    }

}