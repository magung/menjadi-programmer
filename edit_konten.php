<?php 
$halaman = "konten";
include "header.php"; 
include "functions.php"; 
?>
  
      <div class="page-holder w-100 d-flex flex-wrap">
        <div class="container-fluid px-xl-5">
            <section class="py-5">
                <div class="row">
                <div class="col-lg-12 mb-12">
                <?php 
                  //untuk memproses form 
                  if($_SERVER['REQUEST_METHOD']=='POST'){
                      $nama_konten = $_POST['nama_konten'];
                      $kategori    = $_POST['kategori'];
                      $tipe_konten = $_POST['tipe_konten'];
                      $isi_konten  = $_POST['isi_konten'];
                      $link_konten = $_POST['link_konten'];
                      $deskripsi   = $_POST['deskripsi'];
                      $urutan   = $_POST['urutan'];
                      $aktif   = $_POST['aktif'];
                      
                      if($kategori=='' || $nama_konten=='' || $tipe_konten == ''){
                          echo "<div class='alert alert-warning  show alert-dismissible mt-2'>
                                  Data Belum lengkap harus di selesaikan !
                              </div>";	
                      }else{
                        if (isset($_POST['idkonten'])){
                          //simpan data
                          if($_FILES['gambar']['error'] === 4){
                            $gambar = $_POST['gambarlama'];
                          }else {
                            $gambar = upload();
                            hapus_gambar($_POST['gambarlama']);
                          }

                          $id = $_POST['idkonten'];
                          $simpan = mysqli_query($koneksi,
                          "UPDATE `konten` SET `nama` = '$nama_konten', 
                          `deskripsi` = '$deskripsi',
                          `tipe_konten` = $tipe_konten,
                          `link` = '$link_konten',
                          `isi_konten` = '$isi_konten',
                          `kategori` = $kategori,
                          `urutan` = $urutan,
                          `aktif` = $aktif,
                          `foto` = '$gambar',
                          updated_at = NOW() WHERE `konten`.`ID` = $id;");
                          
                          if($simpan){
                            echo "<div class='alert alert-success  show alert-dismissible mt-2'>
                            Data Berhasil diedit
                            </div>";
                            echo "<script>setTimeout(function(){ 
                              window.location.replace('konten.php');
                             }, 2000);</script>";
                          }else{
                            // echo "<script>setTimeout(function(){ 
                            //   window.location.replace('kategori.php');
                            //  }, 2000);</script>";
                            echo "<div class='alert alert-warning  show alert-dismissible mt-2'>
                              Data Gagal diedit
                          </div>";
                          }
                        }else{
                          //simpan data
                          $gambar = upload();
                          $simpan = false;
                          if($gambar !== false){
                            $simpan = mysqli_query($koneksi,
                            "INSERT INTO  konten ( `nama`, `deskripsi`, `foto`, `created_by`, `kategori`, `tipe_konten`, `link`, `isi_konten`) 
                                          VALUES ( '$nama_konten', '$deskripsi', '$gambar', $iduser, $kategori, '$tipe_konten', '$link_konten', '$isi_konten');");
                            // var_dump("INSERT INTO `kategori` (`ID`, `kategori`, `deskripsi`, `foto`, `created_by`) VALUES (NULL, '$kategori', '$deskripsi', '$gambar', $iduser);");
                            // var_dump($koneksi);
                            // var_dump($simpan);die();
                          }
                          // var_dump($simpan);
                          // var_dump($gambar);die();
                          if($simpan){
                            echo "<div class='alert alert-success  show alert-dismissible mt-2'>
                            Data Berhasil disimpan
                            </div>";
                            echo "<script>setTimeout(function(){ 
                              window.location.replace('konten.php');
                             }, 2000);</script>";
                          }else{
                            // echo "<script>setTimeout(function(){ 
                            //   window.location.replace('kategori.php');
                            //  }, 2000);</script>";
                            echo "<div class='alert alert-warning  show alert-dismissible mt-2'>
                              Data Gagal disimpan
                          </div>";
                          }
                        }
                      }
                  }

                  $sql=mysqli_query($koneksi, "SELECT * FROM konten WHERE ID=$_GET[id]");
                  $detail = mysqli_fetch_array($sql);
                  $deskripsiEdit = str_replace( '&', '&amp;', $detail['deskripsi'] );
                  $isiKontenEdit = str_replace( '&', '&amp;', $detail['isi_konten'] );
                  // var_dump($detail['ID']);
                  // die();
        
                ?>
                <div class="card">
                  <div class="card-header">
                    <h6 class="text-uppercase mb-0">Edit Konten</h6><br>
                    <a class='btn btn-danger btn-sm' href='konten.php'>
                    <i class='fas '></i> Back</a>
                  </div>
                  <div class="card-body table-responsive">
                  <form class='col-md-12' method="post" action="" enctype='multipart/form-data'>
                      <input type='hidden' placeholder='kategori' class='form-control' name='idkonten' required value='<?=$detail['ID']?>'>
                      <input type='hidden' class='form-control' name='gambarlama' required value='<?=$detail['foto']?>'>
                      <div class='form-group'>
                        <label class='form-control-label text-uppercase'>Nomor Urut</label>
                        <input type='number' class='form-control' name='urutan' required value='<?=$detail['urutan']?>'>
                      </div>
                      <div class="form-group">
                        <label class="form-control-label text-uppercase">Nama Konten</label>
                        <input type="text" placeholder="nama konten" class="form-control" name='nama_konten' required value='<?= $detail['nama']?>'>
                      </div>

                      <div class='form-group'>
                        <label class='form-control-label text-uppercase'>Status</label>
                        <select name='aktif' class='form-control' required>
                          <option value='1' <?= $detail['aktif']==1?'selected':''?>>Aktif</option>
                          <option value='0' <?= $detail['aktif']!=1?'selected':''?>>Tidak Aktif</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label class="form-control-label text-uppercase">Tipe Konten</label>
                        <select name='tipe_konten' class='form-control' required>
                          <option value='1' <?php echo $detail['tipe_konten'] == 1 ? 'selected' : '' ?>>HTML</option>
                          <option value='2' <?php echo $detail['tipe_konten'] == 2 ? 'selected' : '' ?>>Video Youtube</option>
                          <option value='3' <?php echo $detail['tipe_konten'] == 3 ? 'selected' : '' ?>>Webview</option>
                        </select>
                      </div>
                      <div class='form-group'>
                        <label class='form-control-label text-uppercase'>Kategori</label>
                        
                        <select name='kategori' class='form-control' required>
                          <option value=''>-- pilih kategori --</option>
                          <?php 
                            $sqlkategori=mysqli_query($koneksi, 'SELECT * FROM kategori');  
                            while($datakat=mysqli_fetch_array($sqlkategori)){
                              echo "<option value='$datakat[ID]' ".($detail['kategori'] == $datakat['ID'] ? 'selected' : '')." >$datakat[nama]</option>";
                            }
                          ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label class="form-control-label text-uppercase">Deskripsi</label>
                        <textarea name="deskripsi" id="editor">
                            <?= $deskripsiEdit ?>
                        </textarea>
                      </div>
                      <div class="form-group">
                        <label class="form-control-label text-uppercase">Link Konten</label>
                        <input type="text" placeholder="link konten" class="form-control" name='link_konten' value='<?= $detail['link'] ?>'>
                      </div>
                      <div class="form-group">
                        <label class="form-control-label text-uppercase">Isi Konten</label>
                        <textarea name="isi_konten" id="editorKonten">
                        <?= $isiKontenEdit ?>
                        </textarea>
                      </div>
                      <div class='form-group'>
                        <label class='form-control-label text-uppercase'>Photo</label>
                        <div class='custom-file'>
                          <input type='file' class='custom-file-input' id='photo' name='gambar'>
                          <label class='custom-file-label' for='photo' aria-describedby='inputGroupFileAddon02' >Pilih photo</label>
                        </div>
                        <br><br><img id='photoprofil' src='img/<?= $detail['foto'] ?>' class='img-thumbnail' width='300' height='300'>
                      </div>
                      <div class="form-group text-right"> 
                        <a href='' class='btn btn-secondary' data-dismiss='modal' aria-hidden='true'>Batal</a>       
                        <button type="submit" class="btn btn-primary">Simpan</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
                </div>
            </section>
        </div>
       
        <?php include "footer.php" ?>
      </div>
    </div>
    
    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
        ClassicEditor
            .create( document.querySelector( '#editorKonten' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
    <?php include "script-footer.php" ?>
  </body>
</html>


<script>
$(document).ready(function() {
  // Peringatan hapus dat
  

  function bacaGambar(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#photoprofil').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#photo").change(function() {
    bacaGambar(this);
  });

  function bacaGambar1(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('.gambarbaruedit').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }

  $(".gambaredit").change(function() {
    console.log("tes");
    bacaGambar1(this);
  });

  $('.hapus-data').click(function(){

  var nama = $(this).attr('data-nama');
  $('#nama_kategori').text(nama);

  var id=$(this).data('id');
  var gambar=$(this).data('gambar');
  $('#modalDelete').attr('href','hapus_kategori.php?id='+id+'&gambarlama='+gambar);
  });

})
</script>
