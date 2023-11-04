<?php
require 'koneksi.php';
$nim=$_POST['nim'];
$password=$_POST['password'];
$sql=mysqli_query($koneksi,"select * from akun where nim='$nim' and password='$password'");
$cek=mysqli_num_rows($sql);
if ($cek>0)
{
	$data=mysqli_fetch_array($sql);
	session_start();
	$_SESSION['password']=$password;
	$_SESSION['nim']=$data['nim'];
	header('location:kuadrat1.php');
}
else
{
	?>
	<script type="text/javascript">
		alert ('NIM atau Password Tidak Ditemukan!');
		window.location="index.php";
	</script>
<?php
}
?>