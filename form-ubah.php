<!-- Aplikasi CRUD dengan PDO dan Bootstrap Modal
**************************************************
* Developer    : Indra Styawantoro
* Company      : Indra Studio
* Release Date : 13 Mei 2017
* Website      : www.indrasatya.com
* E-mail       : indra.setyawantoro@gmail.com
* Phone / WA   : +62-856-6991-9769
-->

  <?php
  // Panggil koneksi database
  require_once "config/database.php";

  if (isset($_GET['nim'])) {
    try {
      // sql statement untuk menampilkan data dari tabel is_mahasiswa berdasarkan nim
      $query = "SELECT * FROM is_mahasiswa WHERE nim=:nim";
      // membuat prepared statements
      $stmt = $pdo->prepare($query);

      //mengikat parameter 
      $stmt->bindParam(':nim', $_GET['nim']);

      // eksekusi query
      $stmt->execute();

      // mengambil data mahasiswa
      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      // nilai untuk mengisi form
      $nim           = $data['nim'];
      $nama          = $data['nama'];
      $tempat_lahir  = $data['tempat_lahir'];
      
      $tanggal       = $data['tanggal_lahir'];
      $tgl           = explode('-',$tanggal);
      $tanggal_lahir = $tgl[2]."-".$tgl[1]."-".$tgl[0];
      
      $jenis_kelamin = $data['jenis_kelamin'];
      $agama         = $data['agama'];
      $alamat        = $data['alamat'];
      $telepon       = $data['telepon'];
      $foto          = $data['foto'];

      // tutup koneksi database
      $pdo = null;
    } catch (PDOException $e) {
      // tampilkan pesan kesalahan
      echo "ada kesalahan pada query : ".$e->getMessage();
    }
  }
  ?>
  
  <script type="text/javascript">
    $(function () {
      //datepicker plugin
      $('.date-picker').datepicker({
        autoclose: true,
        todayHighlight: true
      });
    })
  </script>

  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myModalLabel">
          <i class="glyphicon glyphicon-edit"></i> 
          Ubah data mahasiswa
        </h4>
      </div>

      <div class="modal-body">
        <form action="proses-ubah.php" method="POST" name="modal_popup" enctype="multipart/form-data" >
          <div class="form-group">
            <label>NIM</label>
            <input type="text" class="form-control" name="nim" value="<?php echo $nim; ?>" readonly required/>
          </div>

          <div class="form-group">
            <label>Nama mahasiswa</label>
            <input type="text" class="form-control" name="nama" autocomplete="off" value="<?php echo $nama; ?>" required/>
          </div>

          <div class="form-group">
            <label>Tempat Lahir</label>
            <input type="text" class="form-control" name="tempat_lahir" autocomplete="off" value="<?php echo $tempat_lahir; ?>" required/>
          </div>

          <div class="form-group">
            <label>Tanggal Lahir</label>
            <div class="input-group">
              <input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="tanggal_lahir" autocomplete="off" value="<?php echo $tanggal_lahir; ?>" required>
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-calendar"></i>
              </span>
            </div>
          </div>

          <div class="form-group">
            <label>Jenim Kelamin</label>
            <div class="radio">
            <?php
            if ($jenis_kelamin=='Laki-laki') { ?>
              <label class="radio-inline">
                <input type="radio" name="jenis_kelamin" value="Laki-laki" checked> Laki-laki
              </label>

              <label class="radio-inline">
                <input type="radio" name="jenis_kelamin" value="Perempuan"> Perempuan
              </label>
            <?php
            } else { ?>
              <label class="radio-inline">
                <input type="radio" name="jenis_kelamin" value="Laki-laki"> Laki-laki
              </label>

              <label class="radio-inline">
                <input type="radio" name="jenis_kelamin" value="Perempuan" checked> Perempuan
              </label>
            <?php } ?>
            </div>
          </div>

          <div class="form-group">
            <label>Agama</label>
            <select class="form-control" name="agama" placeholder="Pilih Agama" required>
              <option value="<?php echo $agama; ?>"><?php echo $agama; ?></option>
              <option value="Islam">Islam</option>
              <option value="Kristen Protestan">Kristen Protestan</option>
              <option value="Kristen Katolik">Kristen Katolik</option>
              <option value="Hindu">Hindu</option>
              <option value="Buddha">Buddha</option>
            </select>
          </div>

          <div class="form-group">
            <label>Alamat</label>
            <textarea class="form-control" name="alamat" rows="3" required><?php echo $alamat; ?></textarea>
          </div>

          <div class="form-group">
            <label>Telepon</label>
            <input type="text" class="form-control" name="telepon" autocomplete="off" maxlength="13" onKeyPress="return goodchars(event,'0123456789',this)" value="<?php echo $telepon; ?>" required>
          </div>

          <div class="form-group">
            <label>Foto</label> <br>
            <?php  
            if ($foto=="") { ?>
              <img class="img-mahasiswa" src="foto/default_user.png" alt="Foto" width="110">
            <?php
            } else { ?>
              <img class="img-mahasiswa" src="foto/<?php echo $foto; ?>" alt="Foto" width="110">
            <?php
            }
            ?>
            <br><br>
            <input type="file" name="foto">
            <p class="help-block">
              <small>Catatan :</small> <br>
              <small>- Pastikan file yang diupload bertipe *.JPG atau *.PNG</small> <br>
              <small>- Ukuran file foto max 1 Mb</small>
            </p>
          </div>

          <div class="modal-footer">
            <input type="submit" class="btn btn-success btn-submit" name="simpan" value="Simpan">
            <button type="reset" class="btn btn-danger btn-reset" data-dismiss="modal" aria-hidden="true">Batal</button>
          </div>
        </form>
      </div>
    </div>
  </div>