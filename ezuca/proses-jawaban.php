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
        
        if($benar == 3){
            
            $sql3 = "insert into point values(null,:id_cur,:id_user,:score)";
            $stmt = $db->prepare($sql3);
            
            session_start();
            $id_user = $_SESSION['user']['id'];
            $id_cur = $_POST['id_cur'];
            
            
            $sql4 = $db->query("select * from point where id_lecture = $id_cur and id_user = $id_user and $id_cur not in(select id_lecture from point)");
            
            $value4 = $sql4->fetch(PDO::FETCH_ASSOC);
            
            if($value4['score'] == null){
                $score = 100;
            }else{
                $score = $value4['score'] + 100;
            }

            $sql4 = $db->query("select * from point where id_lecture = $id_cur and id_user = $id_user");
            $value4 = $sql4->fetch(PDO::FETCH_ASSOC);

            //bind paramater ke query
            $params = [":id_cur"=>$id_cur,":id_user"=>$id_user,":score"=>$score];
            
            //eksekusi query untuk menyimpan ke database
            $saved = $stmt->execute($params);
            header("location: Apa itu Algoritma.php?id=$id_cur&status=sukses");
        }else{
            $id_cur = $_POST['id_cur'];
            echo $id_cur;
            header("location: Apa itu Algoritma.php?id=$id_cur&status=gagal");
            
        }
    }
?>