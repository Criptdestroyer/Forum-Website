<?php
    require_once("../config.php");
    if(isset($_POST['btn'])){
        $id = $_POST['id'];
        $title = $_POST['title'];
        $curriculum = $_POST['curriculum'];
        $isi = $_POST['isi'];
        $tgl = $_POST['tgl'];
        $bln = $_POST['bln'];
        $thn = $_POST['thn'];
        $date = $thn."-".$bln."-".$tgl;
        if(!empty($_FILES['photo']['name'])){
            $photo = $_FILES['photo']['name'];
            $tempPho = $_FILES['photo']['tmp_name'];
            $imageSize = $_FILES['photo']['size'];
            $dir = "../../images/";
            

            $imgExt = strtolower(pathinfo($photo,PATHINFO_EXTENSION));
            $valid_extensions = array('jpeg','jpg','png','gif');
            $pic = rand(1000,1000000).".".$imgExt;
            $terupload = move_uploaded_file($tempPho,$dir.$pic);
            if($terupload){
                echo "upload";
            }else{
                echo "not";
            }
        }else{
            echo $_POST['pic'];
            $pic = $_POST['pic'];
        }
        
        $sql = "update materi set title = :title,curriculum_id = :curriculum,isi = :isi, time = :date, photo = :photo where id_materi= :id";
            $stmt = $db->prepare($sql);

            //bind paramater ke query
            $params = [":title"=>$title,":curriculum"=>$curriculum,":id"=>$id,":isi"=>$isi,":date"=>$date,":photo"=>$pic];
            var_dump($params);
            //eksekusi query untuk menyimpan ke database
            $saved = $stmt->execute($params);

            if($saved){
                header("location: new_form.php?status=sukses");
            }else{
                header("location: new_form.php?status=gagal");
            }

        
    }else{
        die("Forbidden");
    }
?>