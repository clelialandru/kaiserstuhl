<?php

class tableau{


    public static function row($data, $tag='td'){
        $row ="";
        foreach($data as $valeur){
            $row .= '<'.$tag.'>'.$valeur.'</'.$tag.'>';
        }
        return "<tr>" . $row . "</tr>";            
    }

    public static function head($data=[]){
        $head = "<table>";
        if($data){
            return '<table><thead>'.self::row($data,'th').'</thead>';
        }
        return '<table>' ;

    }

    public static function body($data){
        $body = "";
        foreach($data as $valeur){
            $body .= self::row($valeur); 
        } 
        return "<tbody>". $body ."</tbody>";

    }

    public static function foot($data=[]){
        if($data){
            return '<tfoot>'.self::row($data,'th').'</tfoot></table>';
        }
        return '</table>' ;

    }

}