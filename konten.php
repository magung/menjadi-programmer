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
                          `foto` = '$gambar',
                          updated_at = NOW() WHERE `konten`.`ID` = $id;");
                          
                          if($simpan){
                            // echo "<script>setTimeout(function(){ 
                            //   window.location.replace('kategori.php');
                            //  }, 2000);</script>";
                            echo "<div class='alert alert-success  show alert-dismissible mt-2'>
                              Data Berhasil disimpan
                          </div>";
                          }else{
                            // echo "<script>setTimeout(function(){ 
                            //   window.location.replace('kategori.php');
                            //  }, 2000);</script>";
                            echo "<div class='alert alert-warning  show alert-dismissible mt-2'>
                              Data Gagal disimpan
                          </div>";
                          }
                        }else{
                          //simpan data
                          $gambar = upload();
                          $simpan = false;
                          if($gambar !== false){
                            $simpan = mysqli_query($koneksi,
                            "INSERT INTO  konten ( `nama`, `deskripsi`, `foto`, `created_by`, `kategori`, `tipe_konten`, `link`, `isi_konten`) 
                                          VALUES ( '$konten', '$deskripsi', '$gambar', $iduser, $kategori, '$tipe_konten', '$link_konten', '$isi_konten');");
                            // var_dump("INSERT INTO `kategori` (`ID`, `kategori`, `deskripsi`, `foto`, `created_by`) VALUES (NULL, '$kategori', '$deskripsi', '$gambar', $iduser);");
                            // var_dump($koneksi);
                            // var_dump($simpan);die();
                          }
                          // var_dump($simpan);
                          // var_dump($gambar);die();
                          if($simpan){
                            // echo "<script>setTimeout(function(){ 
                            //   window.location.replace('kategori.php');
                            //  }, 2000);</script>";
                            echo "<div class='alert alert-success  show alert-dismissible mt-2'>
                              Data Berhasil disimpan
                          </div>";
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
        
                ?>
                <div class="card">
                  <div class="card-header">
                    <h6 class="text-uppercase mb-0">Data Konten</h6><br>
                    <a class='btn btn-success btn-sm' href='tambah_konten.php'>
                    <i class='fas fa-plus'></i> Tambah</a>
                  </div>
                  <div class="card-body table-responsive">
                    <table id='dataTables-search' class="table table-striped table-hover card-text">
                      <thead>
                        <tr>
                          <th>No. Urut</th>
                          <th>Nama Konten</th>
                          <th>Kategori</th>
                          <th>Status</th>
                          <th>Tipe Konten</th>
                          <th>Photo</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        $sql=mysqli_query($koneksi, "SELECT kn.*, kt.nama as nama_kategori FROM konten kn JOIN kategori kt on kt.ID = kn.kategori ORDER BY kn.urutan ASC");
                        $no = 1;
                        while($d=mysqli_fetch_array($sql)){
                          $tipeKonten = '';
                          if($d['tipe_konten'] == 1) {
                            $tipeKonten = 'HTML';
                          }
                          if($d['tipe_konten'] == 2) {
                            $tipeKonten = 'Video Youtube';
                          }
                          if($d['tipe_konten'] == 3) {
                            $tipeKonten = 'Webview';
                          }
                          
                          echo "<tr id='search'>
                                  <td>$d[urutan]</td>
                                  <td>$d[nama]</td>
                                  <td>$d[nama_kategori]</td>
                                  <td>".($d['aktif'] == 1 ? "<span class='badge badge-success badge-sm'>Aktif</span>" : "<span class='badge badge-danger badge-sm'>Tidak Aktif</span>")."</td>
                                  <td>$tipeKonten</td>
                                  <td><img src='img/$d[foto]' onerror='this.src='https\:\/\/s3.amazonaws.com/37assets/svn/765-default-avatar.png';this.onerror='';' width='100' height='100'></td>
                                  <td>
                                  <a class='badge badge-success badge-sm' href='edit_konten.php?id=$d[ID]' >
                                  <i class='fas fa-edit'></i> Edit</a>
                                  <a href='#modalHapus' class='hapus-data badge badge-danger badge-sm' data-id='$d[ID]' data-gambar='$d[foto]' 
                                  role='button' data-toggle='modal' data-nama='$d[nama]'>
                                  <i class='fas fa-times'></i> Hapus</a>
                                  <div class='modal small fade' id='modalHapus' tabindex='-1' role='dialog' aria-labelledby='modalHapusLabel' aria-hidden='true'>
                                      <div class='modal-dialog'>
                                          <div class='modal-content'>
                                              <div class='modal-header'>
                                                  <h5 id='modalHapusLabel'>Informasi penghapusan</h5>
                                              </div>
                                              <div class='row modal-body p-3'>
                                                  <div class='col-md-12 text-center'>
                                                      <span class='h6'>Kategori</span>
                                                      <p id='nama_konten' class='h5 text-info mb-3'></p>
                                                  </div>
                                                  <div class='col-md-12 mb-3'>
                                                      <h5> Apakah Anda yakin ingin menghapus data ini ?</h5>
                                                  </div>
                                                  <div class='col-md-12 float-center text-center'>
                                                      <a href='' class='btn btn-primary btn-sm' data-dismiss='modal' aria-hidden='true'>Batal</a> 
                                                      <a href='hapus_konten.php?id=$d[ID]' class='btn btn-danger btn-sm'  id='modalDelete' >Hapus</a>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  </td>
                                </tr>
                              ";
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
                </div>
            </section>
        </div>
        <div class='modal small fade' id='modalTambah' tabindex='-1' role='dialog' aria-labelledby='modalTambahLabel' aria-hidden='true'>
          <div class='modal-dialog'>
              <div class='modal-content'>
                  <div class='modal-header'>
                      <h5 id='modalTambahLabel'>Tambah Kategori</h5>
                  </div>
                  <div class='row modal-body p-3'>
                    <form class='col-md-12' method="post" action="" enctype='multipart/form-data'>
                      <div class="form-group">
                        <label class="form-control-label text-uppercase">Nama Kategori</label>
                        <input type="text" placeholder="kategori" class="form-control" name='kategori' required>
                      </div>
                      <div class="form-group">
                        <label class="form-control-label text-uppercase">Deskripsi</label>
                        <!-- <input type="text" placeholder="deskripsi" class="form-control" name='deskripsi' required> -->
                        <textarea name="deskripsi" id="editor">
                            &lt;p&gt;isi deskripsi disini ini hanyalah sample.&lt;/p&gt;
                        </textarea>
                      </div>
                      <div class='form-group'>
                        <label class='form-control-label text-uppercase'>Photo</label>
                        <div class='custom-file'>
                          <input type='file' class='custom-file-input' id='photo' name='gambar'>
                          <label class='custom-file-label' for='photo' aria-describedby='inputGroupFileAddon02' >Pilih photo</label>
                        </div>
                        <br><br><img id='photoprofil' src='https://www.tibs.org.tw/images/default.jpg' class='img-thumbnail' width='100' height='100'>
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
        <?php include "footer.php" ?>
      </div>
    </div>
    
    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
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

  // $('.hapus-data').click(function(){

  // var nama = $(this).attr('data-nama');
  // $('#nama_konten').text(nama);

  // var id=$(this).data('id');
  // var gambar=$(this).data('gambar');
  // $('#modalDelete').attr('href','hapus_konten.php?id='+id+'&gambarlama='+gambar);
  // });

})
</script>
