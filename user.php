<?php 

$halaman = "user";
include "header.php"; 
include "functions.php"; 

?>
<script>

</script>
  
      <div class="page-holder w-100 d-flex flex-wrap">
        <div class="container-fluid px-xl-5">
          <section class="py-5">
                <div class="row">
                <div class="col-lg-12 mb-12">
                <?php 
                  //untuk memproses form 
                  if($_SERVER['REQUEST_METHOD']=='POST'){
                      // var_dump($_FILES['gambar']);die();
                      $nama         = $_POST['nama'];
                      $username     = $_POST['username'];
                      $password     = $_POST['password'];
                      
                      if($nama=='' || $username==''){
                          echo "<div class='alert alert-warning  show alert-dismissible mt-2'>
                                  Data Belum lengkap harus di selesaikan !
                              </div>";	
                      } else{
                        if (isset($_POST['id_user'])){
                          //simpan data
                          $id = $_POST['id_user'];
                          
                          
                          if($password != '') {
                            $password = md5($password);
                            $password = "`password` = '$password',";
                          }
                          
                          $queryedit = "UPDATE `akun` SET `nama` = '$nama',
                          `username` = '$username',
                          ".$password."
                          updated_at = NOW()
                          WHERE `ID` = $id;";
                          $simpan = mysqli_query($koneksi,$queryedit);
                          // var_dump($gambar);
                          // var_dump($queryedit);
                            // var_dump($simpan);die();
                          
                          if($simpan){
                            echo "<div class='alert alert-success  show alert-dismissible mt-2'>
                            Data Berhasil disimpan
                            </div>";
                            echo "<script>setTimeout(function(){ 
                              window.location.replace('user.php');
                            }, 2000);</script>";
                          }else{
                            // echo "<script>setTimeout(function(){ 
                            //   window.location.replace('user.php');
                            // }, 2000);</script>";
                            echo "<div class='alert alert-warning  show alert-dismissible mt-2'>
                              Data Gagal disimpan
                          </div>";
                          }
                        }else{
                          if($password == '') {
                            echo "<div class='alert alert-warning  show alert-dismissible mt-2'>
                                Data Belum lengkap harus di selesaikan !
                            </div>";	
                          }else{
                            $password = md5($password);
                          
                            //simpan data
                          
                            
                            $simpan = false;
                            $simpan = mysqli_query($koneksi,
                            "INSERT INTO `akun` (`nama`, `username`, `password`) 
                            VALUES ('$nama', '$username', '$password');");
                            
                            // var_dump($gambar);
                            // var_dump($simpan);die();
                            if($simpan){
                              echo "<div class='alert alert-success  show alert-dismissible mt-2'>
                              Data Berhasil disimpan
                              </div>";
                              echo "<script>setTimeout(function(){ 
                                window.location.replace('user.php');
                              }, 2000);</script>";
                            }else{
                              // echo "<script>setTimeout(function(){ 
                              //   window.location.replace('user.php');
                              // }, 2000);</script>";
                              echo "<div class='alert alert-warning  show alert-dismissible mt-2'>
                                Data Gagal disimpan
                            </div>";
                            }

                          }
                        
                        }
                        
                        
                        
                      }
                  }
        
                ?>
                <div class="card">
                  <div class="card-header">
                    <h6 class="text-uppercase mb-0">User</h6><br>
                    <a class='btn btn-success btn-sm' href='#modalTambah' data-toggle='modal'>
                    <i class='fas fa-plus'></i> Tambah</a>
                  </div>
                  <div class="card-body table-responsive">                           
                    <table class="table table-striped table-hover card-text" id='dataTables-search'>
                      <thead>
                        <tr>
                          <th>NO</th>
                          <th>Nama</th>
                          <th>Username</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        $sql=mysqli_query($koneksi, "SELECT * FROM akun");
                        $no = 1;
                        while($d=mysqli_fetch_array($sql)){
                          echo "<tr id='search'>
                                  <td>".$no++."</td>
                                  <td>$d[nama]</td>
                                  <td>$d[username]</td>
                                  <td>";
                                  if($_SESSION['id_user'] == 1 || $_SESSION['id_user'] == $d['ID']) {
                                echo "<a class='badge badge-success badge-sm' href='#modalEdit$d[ID]' data-toggle='modal'>
                                    <i class='fas fa-edit'></i> Edit</a>
                                    <div class='modal small fade' id='modalEdit$d[ID]' tabindex='-1' role='dialog' aria-labelledby='modalEditLabel' aria-hidden='true'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <h5 id='modalEditLabel'>Edit Toko</h5>
                                                </div>
                                                <div class='row modal-body p-3'>
                                                  <form class='col-md-12' method='post' action='' enctype='multipart/form-data'>
                                                    <div class='form-group'>
                                                      <label class='form-control-label text-uppercase'>Nama</label>
                                                      <input type='hidden' placeholder='kategori' class='form-control' name='id_user' required value='$d[ID]'>
                                                      <input type='text' placeholder='nama' class='form-control' name='nama' required value='$d[nama]'>
                                                    </div>
                                                    <div class='form-group'>
                                                      <label class='form-control-label text-uppercase'>Username</label>
                                                      <input type='text' placeholder='username' class='form-control' name='username' required value='$d[username]'>
                                                    </div>
                                                    <div class='form-group'>
                                                      <label class='form-control-label text-uppercase'>Password</label>
                                                      <input type='text' placeholder='kosongkan jika tidak ingin diubah' class='form-control' name='password' value=''>
                                                    </div>
                                                    <div class='form-group text-right'> 
                                                      <a href='' class='btn btn-secondary' data-dismiss='modal' aria-hidden='true'>Batal</a>       
                                                      <button type='submit' class='btn btn-primary'>Simpan</button>
                                                    </div>
                                                  </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>";
                                  }
                                    if($_SESSION['id_user'] != $d['ID'] && $_SESSION['id_user'] == 1){
                                   echo  "<a href='#modalHapus' class='hapus-data badge badge-danger badge-sm' data-id='$d[ID]' ' 
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
                                                        <span class='h6'>User</span>
                                                        <p id='nama_user' class='h5 text-info mb-3'></p>
                                                    </div>
                                                    <div class='col-md-12 mb-3'>
                                                        <h5> Apakah Anda yakin ingin menghapus data ini ?</h5>
                                                    </div>
                                                    <div class='col-md-12 float-center text-center'>
                                                        <a href='' class='btn btn-primary btn-sm' data-dismiss='modal' aria-hidden='true'>Batal</a> 
                                                        <a href='#' class='btn btn-danger btn-sm'  id='modalDelete' >Hapus</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>";
                                    }
                                  echo "</td>
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
        <div class='modal modal-xl fade' id='modalTambah' role='dialog' aria-labelledby='modalTambahLabel' aria-hidden='true'>
          <div class='modal-dialog modal-xl' role="document">
              <div class='modal-content'>
                  <div class='modal-header'>
                      <h5 id='modalTambahLabel'>Tambah Pelanggan Baru</h5>
                  </div>
                  <div class='row modal-body '>
                    <form class='col-md-12' method='post' action='' enctype='multipart/form-data'>
                      <div class='row'>
                        <div class='col-md-12'>
                          <div class='form-group'>
                            <label class='form-control-label text-uppercase'>Nama</label>
                            <input type='text' placeholder='nama' class='form-control' name='nama' required>
                          </div>
                          <div class='form-group'>
                            <label class='form-control-label text-uppercase'>Username</label>
                            <input type='text' placeholder='username' class='form-control' name='username' required>
                          </div>
                          <div class='form-group'>
                            <label class='form-control-label text-uppercase'>Password</label>
                            <input type='text' placeholder='password' class='form-control' name='password' required>
                          </div>
                        </div>
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
        <?php include "footer.php" ?>
      </div>
    </div>
    <!-- JavaScript files-->
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

  $(function(){
    $(".datepicker").datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
    });
    
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
    $('#nama_user').text(nama);

    var id=$(this).data('id');
    $('#modalDelete').attr('href','hapus_user.php?id='+id);
  });
})
</script>

