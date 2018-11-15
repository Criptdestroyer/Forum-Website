<?php
    include("../config.php");
    $id = $_GET['id'];
    $sql = $db->query("select * from curriculum where id_cur = $id");
    $value = $sql->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<?php include("partials/head.php");?>
<body class="single-courses-page">
    <div class="page-header-lecture">
        <?php include("partials/navlectures.php");?>
        <div class="container">
          <div class="row">
            <div class="col-md-12 lecturetitle">
              <h1><?= $value['title']; ?></h1>
              <?php 
                  $sql2 = $db->query("select * from materi where curriculum_id = $id");
                  $i = 1;
                  while($value2 = $sql2->fetch(PDO::FETCH_ASSOC)){
              ?>
              <h2>Lecture <?=$i?> : <span><?=$value2['title']?></span></h2>
            </div>
          </div>
        </div>
    </div><!-- .page-header -->

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12">
              <?=$value2['isi'];?>
            </div><!-- .col -->
                  <?php $i = $i+1;} ?>
            <div class="col-md-12 col-lg-12">
              <form class="" action="proses-jawaban.php" method="post">
                    <input type="hidden" name="id_cur" value="<?= $id ?>">
                <h4>Question</h4>
                <div class="row">

                <?php
                      $j = 1;
                      $sql3 = $db->query("select * from soal where materi_id in(select id_materi from materi where curriculum_id = $id)");
                      while($value3 = $sql3->fetch(PDO::FETCH_ASSOC)){
                    ?>

                  <div class="col-md-12 col-lg-12 myquestion">
                    
                    <div class="number">No <?=$j?></div>
                    <?= $value3['soal']; ?>
                    <!-- <div class="row"> -->
                      <?php
                          $ids = $value3['id_soal']; 
                          $sql4 = $db->query("select * from jawaban where id_soal = $ids");
                          while($value4 = $sql4->fetch(PDO::FETCH_ASSOC)){
                      ?>
                      <div class="col-md-3">
                        <input type="radio" value="<?=$value4['pil']?>" name="<?="no".$j?>"><?=$value4['pil'].". ".$value4['isiPil']?>
                      </div>
                          <?php } ?>
                    <!-- </div> -->
                  </div>
                      <?php $j = $j+1; }?>
                      <input type="submit" name="submit" value="submit">
              </form>

              </div>
            </div><!-- .col -->
        </div><!-- .row -->
    </div><!-- .container -->

    <?php include("partials/logo.php") ?>

  <?php include("partials/footer.php"); ?>

    <script type='text/javascript' src='js/jquery.js'></script>
    <script type='text/javascript' src='js/swiper.min.js'></script>
    <script type='text/javascript' src='js/masonry.pkgd.min.js'></script>
    <script type='text/javascript' src='js/jquery.collapsible.min.js'></script>
    <script type='text/javascript' src='js/custom.js'></script>
    <?php
            if(isset($_GET['status'])){
                if($_GET['status']=="sukses"){
                    echo "<script>alert('Selamat Anda Berhasil Untuk Curriculum ini')</script>";
                }else{
                    echo "<script>alert('Mohon Maaf coba lagi')</script>";
                }

            }
        ?>
</body>
</html>
