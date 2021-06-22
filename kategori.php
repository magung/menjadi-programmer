<?php 
$halaman = "kategori";
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
                      $kategori    = $_POST['kategori'];
                      $deskripsi   = $_POST['deskripsi'];
                      $urutan = $_POST['urutan'];
                      $aktif = $_POST['aktif'];
                      
                      if($kategori==''||$urutan==''){
                          echo "<div class='alert alert-warning  show alert-dismissible mt-2'>
                                  Data Belum lengkap harus di selesaikan !
                              </div>";	
                      }else{
                        if (isset($_POST['idkategori'])){
                          //simpan data
                          if($_FILES['gambar']['error'] === 4){
                            $gambar = $_POST['gambarlama'];
                          }else {
                            $gambar = upload();
                            hapus_gambar($_POST['gambarlama']);
                          }

                          $id = $_POST['idkategori'];
                          $simpan = mysqli_query($koneksi,
                          "UPDATE `kategori` SET `nama` = '$kategori', 
                          `deskripsi` = '$deskripsi',
                          `urutan` = $urutan,
                          `aktif` = $aktif,
                          `foto` = '$gambar',
                          updated_at = NOW() WHERE `kategori`.`ID` = $id;");
                          
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
                          $gambar = false;
                          if($_FILES['gambar']['error'] === 4){
                            $gambar = "";
                          }else {
                            $gambar = upload();
                            hapus_gambar($_POST['gambarlama']);
                          }
                          $simpan = false;
                          if($gambar !== false){
                            $simpan = mysqli_query($koneksi,
                            "INSERT INTO `kategori` (`ID`, `nama`, `deskripsi`, `foto`, `created_by`, `urutan`) VALUES (NULL, '$kategori', '$deskripsi', '$gambar', $iduser, $urutan);");
                            // var_dump("INSERT INTO `kategori` (`ID`, `kategori`, `deskripsi`, `foto`, `created_by`) VALUES (NULL, '$kategori', '$deskripsi', '$gambar', $iduser);");
                            // var_dump($koneksi);
                            // var_dump($simpan);die();
                          } else {
                            echo "<div class='alert alert-success  show alert-dismissible mt-2'>
                              Terjadi Masalah saat upload gambar
                          </div>";
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
                    <h6 class="text-uppercase mb-0">Data Kategori</h6><br>
                    <a class='btn btn-success btn-sm' href='#modalTambah' data-toggle='modal'>
                    <i class='fas fa-plus'></i> Tambah</a>
                  </div>
                  <div class="card-body table-responsive">
                    <table id='dataTables-search' class="table table-striped table-hover card-text">
                      <thead>
                        <tr>
                          <th>No. Urut</th>
                          <th>Kategori</th>
                          <th>Status</th>
                          <th>Photo</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        $sql=mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY urutan ASC");
                        $no = 1;
                        while($d=mysqli_fetch_array($sql)){
                          $deskripsiedit = str_replace( '&', '&amp;', $d['deskripsi'] );
                          echo "<tr id='search'>
                                  <td>$d[urutan]</td>
                                  <td>$d[nama]</td>
                                  <td>".($d['aktif'] == 1 ? "<span class='badge badge-success badge-sm'>Aktif</span>" : "<span class='badge badge-danger badge-sm'>Tidak Aktif</span>")."</td>
                                  <td><img src='img/$d[foto]' onerror='this.src='https\:\/\/s3.amazonaws.com/37assets/svn/765-default-avatar.png';this.onerror='';' width='100' height='100'></td>
                                  <td>
                                  <a class='badge badge-success badge-sm' href='#modalEdit$d[ID]' data-toggle='modal'>
                                  <i class='fas fa-edit'></i> Edit</a>
                                  <div class='modal small fade' id='modalEdit$d[ID]' tabindex='-1' role='dialog' aria-labelledby='modalEditLabel' aria-hidden='true'>
                                      <div class='modal-dialog'>
                                          <div class='modal-content'>
                                              <div class='modal-header'>
                                                  <h5 id='modalEditLabel'>Edit Kategori</h5>
                                              </div>
                                              <div class='row modal-body p-3'>
                                                <form class='col-md-12' method='post' action='' enctype='multipart/form-data'>
                                                  <div class='form-group'>
                                                    <label class='form-control-label text-uppercase'>Kategori</label>
                                                    <input type='hidden' placeholder='kategori' class='form-control' name='idkategori' required value='$d[ID]'>
                                                    <input type='hidden' class='form-control' name='gambarlama' required value='$d[foto]'>
                                                    <input type='text' placeholder='kategori' class='form-control' name='kategori' required value='$d[nama]'>
                                                  </div>
                                                  <div class='form-group'>
                                                    <label class='form-control-label text-uppercase'>Nomor Urut</label>
                                                    <input type='number' class='form-control' name='urutan' required value='$d[urutan]'>
                                                  </div>
                                                  <div class='form-group'>
                                                    <label class='form-control-label text-uppercase'>Status</label>
                                                    <select name='aktif' class='form-control' required>
                                                      <option value='1' ".($d['aktif']==1?'selected':'' ).">Aktif</option>
                                                      <option value='0' ".($d['aktif']!=1?'selected':'' ).">Tidak Aktif</option>
                                                    </select>
                                                  </div>
                                                  <div class='form-group'>
                                                    <label class='form-control-label text-uppercase'>Deskripsi</label>
                                                    <!-- <input type='text' placeholder='deskripsi' class='form-control' name='deskripsi' required> -->
                                                    <textarea name='deskripsi' id='editorEdit$d[ID]'>
                                                        $deskripsiedit
                                                    </textarea>
                                                    <script>
                                                      ClassicEditor
                                                          .create( document.querySelector( '#editorEdit$d[ID]' ) )
                                                          .catch( error => {
                                                              console.error( error );
                                                          } );
                                                  </script>
                                                  </div>
                                                  <div class='form-group'>
                                                      <label class='form-control-label text-uppercase'>gambar</label>
                                                      <div class='custom-file'>
                                                        <input type='file' class='custom-file-input gambaredit' name='gambar'>
                                                        <label class='custom-file-label' for='gambaredit' aria-describedby='inputGroupFileAddon02' >Pilih gambar</label>
                                                      </div>
                                                      <br><br><img src='img/$d[foto]' class='img-thumbnail gambarbaruedit' width='100' height='100'>
                                                  </div>
                                                  <div class='form-group text-right'> 
                                                    <a href='' class='btn btn-secondary' data-dismiss='modal' aria-hidden='true'>Batal</a>       
                                                    <button type='submit' class='btn btn-primary'>Simpan</button>
                                                  </div>
                                                </form>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
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
                                                      <p id='nama_kategori' class='h5 text-info mb-3'></p>
                                                  </div>
                                                  <div class='col-md-12 mb-3'>
                                                      <h5> Apakah Anda yakin ingin menghapus data ini ?</h5>
                                                  </div>
                                                  <div class='col-md-12 float-center text-center'>
                                                      <a href='' class='btn btn-primary btn-sm' data-dismiss='modal' aria-hidden='true'>Batal</a> 
                                                      <a href='hapus_kategori.php?id=$d[ID]' class='btn btn-danger btn-sm'  id='modalDelete' >Hapus</a>
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
                    <input type='hidden' placeholder='kategori' class='form-control' name='aktif' required value='1'>
                      <div class="form-group">
                        <label class="form-control-label text-uppercase">Nama Kategori</label>
                        <input type="text" placeholder="kategori" class="form-control" name='kategori' required>
                      </div>
                      <div class="form-group">
                        <label class="form-control-label text-uppercase">Nomor Urut</label>
                        <?php 
                          $sqlUrutan=mysqli_query($koneksi, "SELECT urutan FROM kategori ORDER BY urutan DESC LIMIT 1");
                          $nomorUrut=mysqli_fetch_array($sqlUrutan);
                          $newUrutan=$nomorUrut['urutan']+1;
                        ?>
                        <input type="number" class="form-control" name='urutan' required value="<?= $newUrutan ?>">
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
  // $('#nama_kategori').text(nama);

  // var id=$(this).data('id');
  // var gambar=$(this).data('gambar');
  // $('#modalDelete').attr('href','hapus_kategori.php?id='+id+'&gambarlama='+gambar);
  // });

})
</script>
