<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: multipart/form-data; boundary=<calculated when request is sent>");
header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "database.php";

class Api{
	public function index() {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                
                $post = $_POST;
                if(isset($post["method"])){
                    $method = $post["method"];
                    // var_dump($post);
                    switch ($method) {
                      case 'GetKategori' :
                        $this->GetKategori($post);
                      break;
                      case 'InsertKategori' :
                          $this->InsertKategori($post);
                      break;
                      case 'UpdateKategori' :
                          $this->UpdateKategori($post);
                      break;
                      case 'DeleteKategori' :
                          $this->DeleteKategori($post);
                      break;
                      case 'GetKonten' :
                          $this->GetKonten($post);
                      break;
                      case 'InsertKonten' :
                          $this->InsertKonten($post);
                      break;
                      case 'UpdateKonten' :
                          $this->UpdateKonten($post);
                      break;
                      case 'DeleteKonten' :
                          $this->DeleteKonten($post);
                      break;
                      
                      default:
                          $this->_result("03", null, 'Invalid Method');
                      break;
                    }
                }else{
                    $this->_result("03", null, 'Method harus diisi');
                }
                
                break;
            default:
                http_response_code(400); // kode bad request
                $this->_result("03", null, 'Bad Request');
                break; 
        }

	}
	
	public function _result($flag = "00", $data = [], $message = '') {
        $result = [
            'err_code'  => $flag,
            'msg'       => $message,
            'data'      => $data
        ];
        print json_encode($result);
	}

    public function compress($source, $destination, $quality) {
        $info = getimagesize($source);
        if ($info['mime'] == 'image/jpeg') 
            $image = imagecreatefromjpeg($source);
        elseif ($info['mime'] == 'image/gif') 
            $image = imagecreatefromgif($source);
        elseif ($info['mime'] == 'image/png') 
            $image = imagecreatefrompng($source);
        imagejpeg($image, $destination, $quality);
        return $destination;
    }
    
    public function upload($file)
    {

        $namaFile = $file['name'];
        $ukuranFile = $file['size'];
        $error = $file['error'];
        $tmpName = $file['tmp_name'];
        $source_properties = getimagesize($tmpName);
        
        // cek apakah tidak ada gambar yang diupload
        if ($error === 4) {
            return false;
        };

        // cek apakah yang diupload adalah gambar
        $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
            $this->_result('01', null, 'Yang anda upload bukan gambar');
            return false;
        }

        // cek ika ukurannya terlalu besar 
        if ($ukuranFile > 10000000) {
            $this->_result('01', null, 'Ukuran gambar terlalu besar');
            return false;
        }

        // jika lolos pengecekan, gambar siap diupload
        // generate nama gambar baru
        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $ekstensiGambar;
        $destination_img = 'img/' . $namaFileBaru;
        $this->compress($tmpName, $destination_img, 65);
        // move_uploaded_file($tmpName, 'img/' . $namaFileBaru);


        return $namaFileBaru;
    }

    public function hapus_gambar($file) {
        // unlink('img/'.$file);
        $filePath = 'img/'.$file;
        if (file_exists($filePath)) 
        {
            unlink($filePath);
        }
    }

    // kategori
    public function GetKategori($post) {
        $db = new Database();
	    $db->open();
        $query = "SELECT * FROM `kategori` WHERE 1=1 ";
        if(isset($post['nama'])) {
          $query .= " AND nama LIKE '%$post[nama]%'";
        }
        $data = $db->get($query);
        $db->close();
	    return $this->_result('00', $data, 'Sukses');
    }

    public function InsertKategori($post) {
	    $db = new Database();
	    $db->open();
      $photo_kategori = "";
      if(isset($_FILES['foto'])) {
          $photo_kategori = $this->upload($_FILES['foto']);
          if(!$photo_kategori){
              return;
          }
      }
      $deskripsi = "";
      if(isset($post['deskripsi'])){
        $deskripsi=$post['deskripsi'];
      }
      $createdby = 0;
      if(isset($post['created_by'])){
        $createdby=$post['created_by'];
      }
      $sql = "INSERT INTO `kategori` ( `nama`, `deskripsi`, `foto`, `created_by`) 
              VALUES ('$post[nama]', '$deskripsi', '$photo_kategori', $createdby);";
      $res = $db->execute($sql);
      if($res === true){
          return $this->_result('00', $res, 'Sukses');
      }else{
          return $this->_result('01', null, $res);
      }
      $db->close();
	  }

    public function UpdateKategori($post) {
        $db = new Database();
	    $db->open();
	    if(!isset($post['ID'])) {
	        return $this->_result('01', null, 'id required');
	    }
	    $query = "UPDATE `kategori` SET ";

        if(isset($post['nama'])){
            $query .= " `nama` = '$post[nama]', ";
        }
        if(isset($post['deskripsi'])){
          $query .= " `deskripsi` = '$post[deskripsi]', ";
      }
        if(isset($post['updated_by'])){
            $query .= " `updated_by` = $post[updated_by], ";
        }
        if(isset($_FILES['foto'])){
            $namaPhoto = $this->upload($_FILES['foto']);
            if($namaPhoto) {
                $query .= " `foto` = '$namaPhoto', ";
            }else{
                return;
            }
        }
        $query .= " `updated_at` = '".date('Y-m-d H:i:s')."' WHERE `ID` = $post[ID];";
        $res = $db->execute($query);
        $db->close();
        if($res === true){
	        return $this->_result('00', $res, 'Sukses');
	    }else{
            return $this->_result('01', $res, 'Gagal');
        }
    }

    public function DeleteKategori($post) {
        $db = new Database();
	    $db->open();
	    if(!isset($post['ID'])) {
	        return $this->_result('01', null, 'id required');
	    }
	    $query = "DELETE FROM `kategori` WHERE `ID` = $post[ID];";
        $res = $db->execute($query);
        $db->close();
        if($res === true){
	        return $this->_result('00', $res, 'Sukses');
	    }else{
            return $this->_result('01', $res, 'Gagal');
        }
    }
    // end kategori

    // konten
    public function GetKonten($post) {
      $db = new Database();
    $db->open();
      $query = "SELECT * FROM `konten` WHERE 1=1 ";
      if(isset($post['kategori'])) {
        $query .= " AND kategori=$post[kategori]";
      }
      if(isset($post['nama'])) {
        $query .= " AND nama LIKE '%$post[nama]%'";
      }
      $data = $db->get($query);
      $db->close();
    return $this->_result('00', $data, 'Sukses');
  }

  public function InsertKonten($post) {
    $db = new Database();
    $db->open();
    $photo_konten = "";
    if(isset($_FILES['foto'])) {
        $photo_konten = $this->upload($_FILES['foto']);
        if(!$photo_konten){
            return;
        }
    }
    $deskripsi = "";
    if(isset($post['deskripsi'])){
      $deskripsi=$post['deskripsi'];
    }
    $link = "";
    if(isset($post['link'])){
      $link=$post['link'];
    }
    $isi_konten = "";
    if(isset($post['isi_konten'])){
      $isi_konten=$post['isi_konten'];
    }
    $tipe_konten = 1;
    if(isset($post['tipe_konten'])){
      $tipe_konten=$post['tipe_konten'];
    }
    $kategori = 1;
    if(isset($post['kategori'])){
      $kategori=$post['kategori'];
    }
    $createdby = 0;
    if(isset($post['created_by'])){
      $createdby=$post['created_by'];
    }
    $sql = "INSERT INTO `konten` ( `nama`, `deskripsi`, `tipe_konten`, `link`, `isi_konten`, `foto`, `kategori`, `created_by`) 
            VALUES ('$post[nama]', '$deskripsi', $tipe_konten, '$link', '$isi_konten', '$photo_konten', $kategori, $createdby);";
    $res = $db->execute($sql);
    if($res === true){
        return $this->_result('00', $res, 'Sukses');
    }else{
        return $this->_result('01', null, $res);
    }
    $db->close();
  }

  public function UpdateKonten($post) {
      $db = new Database();
    $db->open();
    if(!isset($post['ID'])) {
        return $this->_result('01', null, 'id required');
    }
    $query = "UPDATE `konten` SET ";

      if(isset($post['nama'])){
          $query .= " `nama` = '$post[nama]', ";
      }
      if(isset($post['deskripsi'])){
        $query .= " `deskripsi` = '$post[deskripsi]', ";
      }
      if(isset($post['link'])){
        $query .= " `link` = '$post[deskripsi]', ";
      }
      if(isset($post['isi_konten'])){
        $query .= " `isi_konten` = '$post[isi_konten]', ";
      }
      if(isset($post['updated_by'])){
          $query .= " `updated_by` = $post[updated_by], ";
      }
      if(isset($_FILES['foto'])){
          $namaPhoto = $this->upload($_FILES['foto']);
          if($namaPhoto) {
              $query .= " `foto` = '$namaPhoto', ";
          }else{
              return;
          }
      }
      $query .= " `updated_at` = '".date('Y-m-d H:i:s')."' WHERE `ID` = $post[ID];";
      $res = $db->execute($query);
      $db->close();
      if($res === true){
        return $this->_result('00', $res, 'Sukses');
    }else{
          return $this->_result('01', $res, 'Gagal');
      }
  }

  public function DeleteKonten($post) {
      $db = new Database();
    $db->open();
    if(!isset($post['ID'])) {
        return $this->_result('01', null, 'id required');
    }
    $query = "DELETE FROM `konten` WHERE `ID` = $post[ID];";
      $res = $db->execute($query);
      $db->close();
      if($res === true){
        return $this->_result('00', $res, 'Sukses');
    }else{
          return $this->_result('01', $res, 'Gagal');
      }
  }
  // end konten
}

$dd = new Api();
$dd->index();
?>