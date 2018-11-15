<?php
    include("../config.php");
    if(($_POST['submit'])){
        $sql = $db->query("select count(id_soal) as jumlah from soal");
        $value = $sql->fetch(PDO::FETCH_ASSOC);
        
        for ($i=0; $i < $value['jumlah']; $i++) { 
            $arr[] = $_POST['no'.($i+1)];
        }
        
        $sql2 = $db->query("select *  from soal");
        $benar = 0;
        $j = 0;
        while($value2 = $sql2->fetch(PDO::FETCH_ASSOC)){
            
            if($value2['jawaban'] == $arr[$j]){
                $benar = $benar+1;
            }
            $j = $j+1;
        }
        
    }
?>