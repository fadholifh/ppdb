<?php require_once('../Connections/connect.php'); ?>
<?php include('auth.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO ppdb_biodata (nama_lengkap, jenis_kelamin, id_agama, tempat_lahir, tanggal_lahir, alamat_rumah, rt_rw, kecamatan, kabupaten, kode_pos, no_hp_calon_siswa, tinggi_badan, berat_badan, golongan_darah, nama_ayah_kandung, id_pekerjaan_ayah, nama_ibu_kandung, id_pekerjaan_ibu, no_hp_orang_tua, asal_sekolah, tahun_lulus, piagam_prestasi, fc_raport, ijasah, skhun, id_program_studi, tempat_daftar, mengetahui, jalur, id_petugas) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nama_lengkap'], "text"),
                       GetSQLValueString($_POST['jenis_kelamin'], "text"),
                       GetSQLValueString($_POST['id_agama'], "int"),
                       GetSQLValueString($_POST['tempat_lahir'], "text"),
                       GetSQLValueString($_POST['tanggal_lahir'], "date"),
                       GetSQLValueString($_POST['alamat_rumah'], "text"),
                       GetSQLValueString($_POST['rt_rw'], "text"),
                       GetSQLValueString($_POST['kecamatan'], "text"),
                       GetSQLValueString($_POST['kabupaten'], "text"),
                       GetSQLValueString($_POST['kode_pos'], "int"),
                       GetSQLValueString($_POST['no_hp_calon_siswa'], "text"),
                       GetSQLValueString($_POST['tinggi_badan'], "int"),
                       GetSQLValueString($_POST['berat_badan'], "int"),
                       GetSQLValueString($_POST['golongan_darah'], "text"),
                       GetSQLValueString($_POST['nama_ayah_kandung'], "text"),
                       GetSQLValueString($_POST['id_pekerjaan_ayah'], "int"),
                       GetSQLValueString($_POST['nama_ibu_kandung'], "text"),
                       GetSQLValueString($_POST['id_pekerjaan_ibu'], "int"),
                       GetSQLValueString($_POST['no_hp_orang_tua'], "text"),
                       GetSQLValueString($_POST['asal_sekolah'], "text"),
                       GetSQLValueString($_POST['tahun_lulus'], "date"),
                       GetSQLValueString(isset($_POST['piagam_prestasi']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['fc_raport']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['ijasah']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['skhun']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['id_program_studi'], "int"),
                       GetSQLValueString($_POST['tempat_daftar'], "text"),
                       GetSQLValueString($_POST['mengetahui'], "text"),
                       GetSQLValueString($_POST['jalur'], "text"),
                       GetSQLValueString($_POST['id_petugas'], "int"));

  mysql_select_db($database_connect, $connect);
  $Result1 = mysql_query($insertSQL, $connect) or die(mysql_error());

  $insertGoTo = "input_nilai_pertama.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_connect, $connect);
$query_ext_agama = "SELECT * FROM `ext_agama` WHERE `status` = 1";
$ext_agama = mysql_query($query_ext_agama, $connect) or die(mysql_error());
$row_ext_agama = mysql_fetch_assoc($ext_agama);
$totalRows_ext_agama = mysql_num_rows($ext_agama);

mysql_select_db($database_connect, $connect);
$query_ext_pekerjaan_ibu = "SELECT * FROM `ext_pekerjaan_ortu` WHERE   `status` = 1  ";
$ext_pekerjaan_ibu = mysql_query($query_ext_pekerjaan_ibu, $connect) or die(mysql_error());
$row_ext_pekerjaan_ibu = mysql_fetch_assoc($ext_pekerjaan_ibu);
$totalRows_ext_pekerjaan_ibu = mysql_num_rows($ext_pekerjaan_ibu);

mysql_select_db($database_connect, $connect);
$query_ext_pekerjaan_ayah = "SELECT * FROM `ext_pekerjaan_ortu` WHERE `tipe_pekerjaan` = 1 AND `status` = 1  ";
$ext_pekerjaan_ayah = mysql_query($query_ext_pekerjaan_ayah, $connect) or die(mysql_error());
$row_ext_pekerjaan_ayah = mysql_fetch_assoc($ext_pekerjaan_ayah);
$totalRows_ext_pekerjaan_ayah = mysql_num_rows($ext_pekerjaan_ayah);

mysql_select_db($database_connect, $connect);
$query_ext_program_studi = "SELECT * FROM `ext_program_studi` WHERE `status` = 1";
$ext_program_studi = mysql_query($query_ext_program_studi, $connect) or die(mysql_error());
$row_ext_program_studi = mysql_fetch_assoc($ext_program_studi);
$totalRows_ext_program_studi = mysql_num_rows($ext_program_studi);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Input Bioadata</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="nav">
    <table width="73%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><?php include('../inc/header.php') ?></td>
  </tr>
</table>
</div>
<br />
<br />
<br />
<br />
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Nama Lengkap</td>
      <td><input type="text" name="nama_lengkap" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Jenis Kelamin</td>
      <td><select name="jenis_kelamin">
        <option value="L" <?php if (!(strcmp("L", ""))) {echo "SELECTED";} ?>>Laki-Laki</option>
        <option value="P" <?php if (!(strcmp("P", ""))) {echo "SELECTED";} ?>>Perempuan</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Agama</td>
      <td><select name="id_agama">
        <?php 
do {  
?>
        <option value="<?php echo $row_ext_agama['id_agama']?>" ><?php echo $row_ext_agama['nama']?></option>
        <?php
} while ($row_ext_agama = mysql_fetch_assoc($ext_agama));
?>
      </select></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Tempat Lahir</td>
      <td><input type="text" name="tempat_lahir" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Tanggal Lahir</td>
      <td><input type="text" name="tanggal_lahir" value="" size="32" placeholder="YYYY-MM-DD" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Alamat Rumah</td>
      <td><input type="text" name="alamat_rumah" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">RT./RW.</td>
      <td><input type="text" name="rt_rw" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Kecamatan</td>
      <td><input type="text" name="kecamatan" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Kabupaten</td>
      <td><input type="text" name="kabupaten" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Kode Pos</td>
      <td><input type="text" name="kode_pos" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">No. HP Calon Siswa:</td>
      <td><input type="text" name="no_hp_calon_siswa" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Tinggi Badan</td>
      <td><input type="text" name="tinggi_badan" value="" size="32" /> Cm</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Berat Badan</td>
      <td><input type="text" name="berat_badan" value="" size="32" /> Kg</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Golongan Darah</td>
      <td><select name="golongan_darah">
        <option value="A" <?php if (!(strcmp("A", ""))) {echo "SELECTED";} ?>>A</option>
        <option value="B" <?php if (!(strcmp("B", ""))) {echo "SELECTED";} ?>>B</option>
        <option value="AB" <?php if (!(strcmp("AB", ""))) {echo "SELECTED";} ?>>AB</option>
        <option value="O" <?php if (!(strcmp("O", ""))) {echo "SELECTED";} ?>>O</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Nama Ayah Kandung:</td>
      <td><input type="text" name="nama_ayah_kandung" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Pekerjaan Ayah Kandung</td>
      <td><select name="id_pekerjaan_ayah">
        <?php 
do {  
?>
        <option value="<?php echo $row_ext_pekerjaan_ayah['id_pekerjaan_ortu']?>" ><?php echo $row_ext_pekerjaan_ayah['nama_pekerjaan']?></option>
        <?php
} while ($row_ext_pekerjaan_ayah = mysql_fetch_assoc($ext_pekerjaan_ayah));
?>
      </select></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Nama Ibu Kandung</td>
      <td><input type="text" name="nama_ibu_kandung" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Pekerjaan Ibu Kandung</td>
      <td><select name="id_pekerjaan_ibu">
        <?php 
do {  
?>
        <option value="<?php echo $row_ext_pekerjaan_ibu['id_pekerjaan_ortu']?>" ><?php echo $row_ext_pekerjaan_ibu['nama_pekerjaan']?></option>
        <?php
} while ($row_ext_pekerjaan_ibu = mysql_fetch_assoc($ext_pekerjaan_ibu));
?>
      </select></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">No. HP Orang Tua</td>
      <td><input type="text" name="no_hp_orang_tua" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Asal Sekolah</td>
      <td><input type="text" name="asal_sekolah" value="" size="32" placeholder="SMPN XXX" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Tahun Lulus</td>
      <td><input type="text" name="tahun_lulus" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Piagam Prestasi</td>
      <td><input type="checkbox" name="piagam_prestasi" value="" checked="checked" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">FC. Raport Smt 1-5</td>
      <td><input type="checkbox" name="fc_raport" value="" checked="checked" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Ijasah</td>
      <td><input type="checkbox" name="ijasah" value="" checked="checked" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">SKHUN</td>
      <td><input type="checkbox" name="skhun" value="" checked="checked" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Program Studi</td>
      <td><select name="id_program_studi">
        <?php 
do {  
?>
        <option value="<?php echo $row_ext_program_studi['id_program_studi']?>" ><?php echo $row_ext_program_studi['nama_studi']?></option>
        <?php
} while ($row_ext_program_studi = mysql_fetch_assoc($ext_program_studi));
?>
      </select></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Tempat Daftar</td>
      <td><input type="text" name="tempat_daftar" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Mengetahui</td>
      <td><input type="text" name="mengetahui" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Jalur</td>
      <td><select name="jalur">
        <option value="REGULER" <?php if (!(strcmp("REGULER", ""))) {echo "SELECTED";} ?>>Reguler</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">&nbsp;</td>
      <td><input type="submit" value="Simpan" /></td>
    </tr>
  </table>
  <input type="hidden" name="id_petugas" value="<?php echo 1; ?>" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($ext_agama);

mysql_free_result($ext_pekerjaan_ibu);

mysql_free_result($ext_pekerjaan_ayah);

mysql_free_result($ext_program_studi);
?>
