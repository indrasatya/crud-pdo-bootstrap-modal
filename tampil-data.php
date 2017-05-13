<!-- Aplikasi CRUD dengan PDO dan Bootstrap Modal
**************************************************
* Developer    : Indra Styawantoro
* Company      : Indra Studio
* Release Date : 13 Mei 2017
* Website      : www.indrasatya.com
* E-mail       : indra.setyawantoro@gmail.com
* Phone / WA   : +62-856-6991-9769
-->

  <div class="row">
    <div class="col-md-12">
      <div class="page-header">
        <h4>
          <i class="glyphicon glyphicon-user"></i> Data Mahasiswa
          
          <a class="btn btn-success pull-right" href="#" data-target="#modal_tambah" data-toggle="modal">
            <i class="glyphicon glyphicon-plus"></i> Tambah
          </a>
        </h4>
      </div>

  <?php  
  // fungsi untuk menampilkan pesan
  // jika alert = "" (kosong)
  // tampilkan pesan "" (kosong)
  if (empty($_GET['alert'])) {
    echo "";
  }
  // jika alert = 1
  // tampilkan pesan Sukses "Mahasiswa baru berhasil disimpan" 
  elseif ($_GET['alert'] == 1) {
    echo "<div class='alert alert-success alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
            <strong><i class='glyphicon glyphicon-ok-circle'></i> Sukses!</strong> Data mahasiswa berhasil disimpan.
          </div>";
  } 
  // jika alert = 2
  // tampilkan pesan Sukses "Mahasiswa berhasil diubah"
  elseif ($_GET['alert'] == 2) {
    echo "<div class='alert alert-success alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
            <strong><i class='glyphicon glyphicon-ok-circle'></i> Sukses!</strong> Data mahasiswa berhasil diubah.
          </div>";
  } 
  // jika alert = 3
  // tampilkan pesan Sukses "Mahasiswa berhasil dihapus"
  elseif ($_GET['alert'] == 3) {
    echo "<div class='alert alert-success alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
            <strong><i class='glyphicon glyphicon-ok-circle'></i> Sukses!</strong> Data mahasiswa berhasil dihapus.
          </div>";
  }
  // jika alert = 4
  // tampilkan pesan Gagal "NIM sudah ada"
  elseif ($_GET['alert'] == 4) {
    echo "<div class='alert alert-danger alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
            <strong><i class='glyphicon glyphicon-remove-circle'></i> Gagal!</strong> NIM $_GET[nim] sudah ada.
          </div>";
  }
  // jika alert = 5
  // tampilkan pesan Upload Gagal "Pastikan file yang diupload sudah benar"
  elseif ($_GET['alert'] == 5) {
  echo "  <div class='alert alert-danger alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
            <strong><i class='glyphicon glyphicon-remove-circle'></i> Upload Gagal!</strong> Pastikan file yang diupload sudah benar.
          </div>";
  }
  // jika alert = 6
  // tampilkan pesan Upload Gagal "Pastikan ukuran file foto tidak lebih dari 1MB"
  elseif ($_GET['alert'] == 6) {
  echo "  <div class='alert alert-danger alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
            <strong><i class='glyphicon glyphicon-remove-circle'></i> Upload Gagal!</strong> Pastikan ukuran file foto tidak lebih dari 1MB.
          </div>";
  }
  // jika alert = 7
  // tampilkan pesan Upload Gagal "Pastikan file yang diupload bertipe *.JPG, *.JPEG, *.PNG"
  elseif ($_GET['alert'] == 7) {
  echo "  <div class='alert alert-danger alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
            <strong><i class='glyphicon glyphicon-remove-circle'></i> Upload Gagal!</strong> Pastikan file yang diupload bertipe *.JPG, *.JPEG, *.PNG.
          </div>";
  }
  ?>

      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Data Mahasiswa</h3>
        </div>
        <div class="panel-body">
          <table class="table table-striped table-hover" id="dataTables-example">
            <thead>
              <tr>
                <th>No.</th>
                <th>Foto</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Tempat, Tanggal Lahir</th>
                <th>Jenim Kelamin</th>
                <th>Agama</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th></th>
              </tr>
            </thead>   

            <tbody>
            <?php
            try {
              $no = 1;

              // sql statement untuk menampilkan semua data dari tabel is_mahasiswa
              $query = "SELECT * FROM is_mahasiswa ORDER BY nim DESC";
              // membuat prepared statements
              $stmt = $pdo->prepare($query);

              // eksekusi query
              $stmt->execute();

              // tampilkan data
              while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $tanggal        = $data['tanggal_lahir'];
                $tgl            = explode('-',$tanggal);
                $tanggal_lahir  = $tgl[2]."-".$tgl[1]."-".$tgl[0];

                echo "<tr>
                        <td width='50' class='center'>$no</td>";

                        if ($data['foto']=="") { ?>
                          <td><img class='img-mahasiswa' src='foto/default_user.png' width='45'></td>
                        <?php
                        } else { ?>
                          <td><img class='img-mahasiswa' src='foto/<?php echo $data['foto']; ?>' width='45'></td>
                        <?php
                        }

                echo "  <td width='60'>$data[nim]</td>
                        <td width='150'>$data[nama]</td>
                        <td width='180'>$data[tempat_lahir], $tanggal_lahir</td>
                        <td width='120'>$data[jenis_kelamin]</td>
                        <td width='100'>$data[agama]</td>
                        <td width='250'>$data[alamat]</td>
                        <td width='80'>$data[telepon]</td>

                        <td width='100'>
                          <div class=''>
                            <a href='#' data-toggle='tooltip' data-placement='top' title='Ubah' style='margin-right:5px' class='btn btn-success btn-sm open_modal' id='$data[nim]' >
                              <i class='glyphicon glyphicon-edit'></i>
                            </a>";
                ?>
                            <a href="#" onclick="confirm_modal('proses-hapus.php?&nim=<?php echo $data['nim']; ?>');" data-nim="<?php echo $data['nim']; ?>" data-toggle="tooltip" data-placement="top" title="Hapus" class="btn btn-danger btn-sm">
                              <i class="glyphicon glyphicon-trash"></i>
                            </a>
              <?php
                echo "
                          </div>
                        </td>
                      </tr>";
                $no++;
              }

              // tutup koneksi database
              $pdo = null;
            } catch (PDOException $e) {
              // tampilkan pesan kesalahan
              echo "ada kesalahan pada query : ".$e->getMessage();
            }
            ?>
            </tbody>           
          </table>
        </div>
      </div> <!-- /.panel -->
    </div> <!-- /.col -->
  </div> <!-- /.row -->
  
  <!-- Modal Popup untuk tambah--> 
  <div id="modal_tambah" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="myModalLabel">
            <i class="glyphicon glyphicon-edit"></i> 
            Input data mahasiswa
          </h4>
        </div>

        <div class="modal-body">
          <form action="proses-simpan.php" method="POST" name="modal_popup" enctype="multipart/form-data">
            
            <div class="form-group">
              <label>NIM</label>
              <input type="text" class="form-control" name="nim" autocomplete="off" maxlength="10" required/>
            </div>

            <div class="form-group">
              <label>Nama Mahasiswa</label>
              <input type="text" class="form-control" name="nama" autocomplete="off" required/>
            </div>

            <div class="form-group">
              <label>Tempat Lahir</label>
              <input type="text" class="form-control" name="tempat_lahir" autocomplete="off" required/>
            </div>

            <div class="form-group">
              <label>Tanggal Lahir</label>
              <div class="input-group">
                <input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="tanggal_lahir" autocomplete="off" required>
                <span class="input-group-addon">
                  <i class="glyphicon glyphicon-calendar"></i>
                </span>
              </div>
            </div>

            <div class="form-group">
              <label>Jenis Kelamin</label>
              <div class="radio">
                <label class="radio-inline">
                  <input type="radio" name="jenis_kelamin" value="Laki-laki"> Laki-laki
                </label>

                <label class="radio-inline">
                  <input type="radio" name="jenis_kelamin" value="Perempuan"> Perempuan
                </label>
              </div>
            </div>

            <div class="form-group">
              <label>Agama</label>
              <select class="form-control" name="agama" placeholder="Pilih Agama" required>
                <option value=""></option>
                <option value="Islam">Islam</option>
                <option value="Kristen Protestan">Kristen Protestan</option>
                <option value="Kristen Katolik">Kristen Katolik</option>
                <option value="Hindu">Hindu</option>
                <option value="Buddha">Buddha</option>
              </select>
            </div>

            <div class="form-group">
              <label>Alamat</label>
              <textarea class="form-control" name="alamat" rows="3" required></textarea>
            </div>

            <div class="form-group">
              <label>Telepon</label>
              <input type="text" class="form-control" name="telepon" autocomplete="off" maxlength="13" onKeyPress="return goodchars(event,'0123456789',this)" required>
            </div>

            <div class="form-group">
              <label>Foto</label>
              <input type="file" name="foto" required>
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
  </div>

  <!-- Modal Popup untuk ubah--> 
  <div id="modal_ubah" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  </div>

  <!-- Modal Popup untuk hapus -->
  <div class="modal fade" id="modal_hapus">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><i style="margin-right:7px" class="glyphicon glyphicon-trash"></i> Anda yakin ingin menghapus data mahasiswa ?</h4>
        </div>
        <div class="modal-footer">
          <a href="#" type="button" class="btn btn-danger btn-submit" id="link_hapus">Ya, Hapus</a>
          <button type="button" class="btn btn-default btn-reset" data-dismiss="modal">Batal</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->