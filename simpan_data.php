<?php
require 'koneksi.php';
$nim=$_POST['nim'];
$nama=$_POST['nama'];
$password=$_POST['password'];

$sql=mysqli_query($koneksi,"insert into akun values('$nim', '$nama', '$password')");
if ($sql)
{
	?>
	<script type="text/javascript">
		alert ('Data Registrasi Berhasil Disimpan! Silakan Gunakan Untuk Masuk!');
		window.location="index.php";
	</script>
<?php
}
?>