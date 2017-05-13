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

if (isset($_POST['simpan'])) {
	if (isset($_POST['nim'])) {
		// ambil data hasil submit dari form
		$nim                = trim($_POST['nim']);
		$nama               = trim($_POST['nama']);
		$tempat_lahir       = trim($_POST['tempat_lahir']);
		
		$tanggal            = trim($_POST['tanggal_lahir']);
		$tgl                = explode('-',$tanggal);
		$tanggal_lahir      = $tgl[2]."-".$tgl[1]."-".$tgl[0];
		
		$jenis_kelamin      = trim($_POST['jenis_kelamin']);
		$agama              = trim($_POST['agama']);
		$alamat             = trim($_POST['alamat']);
		$telepon            = trim($_POST['telepon']);
		
		$nama_file          = $_FILES['foto']['name'];
		$ukuran_file        = $_FILES['foto']['size'];
		$tipe_file          = $_FILES['foto']['type'];
		$tmp_file           = $_FILES['foto']['tmp_name'];
		
		// tentukan extension yang diperbolehkan
		$allowed_extensions = array('jpg','jpeg','png');
		
		// Set path folder tempat menyimpan gambarnya
		$path_file          = "foto/".$nama_file;
		
		// check extension
		$file               = explode(".", $nama_file);
		$extension          = array_pop($file);

		try {
			// jika foto diubah
			if (empty($_FILES['foto']['name'])) {
				// sql statement untuk mengubah data pada tabel is_mahasiswa
		        $query = "UPDATE is_mahasiswa SET nama 			= :nama,
												  tempat_lahir 	= :tempat_lahir,
												  tanggal_lahir = :tanggal_lahir,
												  jenis_kelamin = :jenis_kelamin,
												  agama 		= :agama,
												  alamat 		= :alamat,
												  telepon 		= :telepon
										    WHERE nim 			= :nim";
		        // membuat prepared statements
		        $stmt = $pdo->prepare($query);

		        // mengikat parameter
				$stmt->bindParam(':nim', $nim);
				$stmt->bindParam(':nama', $nama);
				$stmt->bindParam(':tempat_lahir', $tempat_lahir);
				$stmt->bindParam(':tanggal_lahir', $tanggal_lahir);
				$stmt->bindParam(':jenis_kelamin', $jenis_kelamin);
				$stmt->bindParam(':agama', $agama);
				$stmt->bindParam(':alamat', $alamat);
				$stmt->bindParam(':telepon', $telepon);
			}
			// jika foto tidak diubah
			else {
				// Cek apakah tipe file yang diupload sesuai dengan allowed_extensions
				if (in_array($extension, $allowed_extensions)) {
	                // Jika tipe file yang diupload sesuai dengan allowed_extensions, lakukan :
	                if($ukuran_file <= 1000000) { // Cek apakah ukuran file yang diupload kurang dari sama dengan 1MB
	                    // Jika ukuran file kurang dari sama dengan 1MB, lakukan :
	                    // Proses upload
	                    if(move_uploaded_file($tmp_file, $path_file)) { // Cek apakah gambar berhasil diupload atau tidak
	                		// Jika gambar berhasil diupload, Lakukan : 
					        // sql statement untuk mengubah data pada tabel is_mahasiswa
					        $query = "UPDATE is_mahasiswa SET nama 			= :nama,
															  tempat_lahir 	= :tempat_lahir,
															  tanggal_lahir = :tanggal_lahir,
															  jenis_kelamin = :jenis_kelamin,
															  agama 		= :agama,
															  alamat 		= :alamat,
															  telepon 		= :telepon,
															  foto 			= :foto
													    WHERE nim 			= :nim";
					        // membuat prepared statements
					        $stmt = $pdo->prepare($query);

					        // mengikat parameter
							$stmt->bindParam(':nim', $nim);
							$stmt->bindParam(':nama', $nama);
							$stmt->bindParam(':tempat_lahir', $tempat_lahir);
							$stmt->bindParam(':tanggal_lahir', $tanggal_lahir);
							$stmt->bindParam(':jenis_kelamin', $jenis_kelamin);
							$stmt->bindParam(':agama', $agama);
							$stmt->bindParam(':alamat', $alamat);
							$stmt->bindParam(':telepon', $telepon);
							$stmt->bindParam(':foto', $nama_file);
	                    } else {
	                        // Jika gambar gagal diupload, tampilkan pesan gagal upload
	                        header("location: index.php?alert=5");
	                    }
	                } else {
	                    // Jika ukuran file lebih dari 1MB, tampilkan pesan gagal upload
	                    header("location: index.php?alert=6");
	                }
	            } else {
	                // Jika tipe file yang diupload bukan jpg, jpeg, png, tampilkan pesan gagal upload
	                header("location: index.php?alert=7");
	            }
	        }

			// eksekusi query
	        $stmt->execute();

	        // jika berhasil tampilkan pesan berhasil update data
			header('location: index.php?alert=2');

			// tutup koneksi database
	        $pdo = null;
		} catch (PDOException $e) {
			// tampilkan pesan kesalahan
	        echo "ada kesalahan : ".$e->getMessage();
		}
	}
}				
?>