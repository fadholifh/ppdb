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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE ppdb_biodata SET nomor_pendaftaran=%s, nama_lengkap=%s, jenis_kelamin=%s, id_agama=%s, tempat_lahir=%s, tanggal_lahir=%s, alamat_rumah=%s, rt_rw=%s, kecamatan=%s, kabupaten=%s, kode_pos=%s, no_hp_calon_siswa=%s, tinggi_badan=%s, berat_badan=%s, golongan_darah=%s, nama_ayah_kandung=%s, id_pekerjaan_ayah=%s, nama_ibu_kandung=%s, id_pekerjaan_ibu=%s, no_hp_orang_tua=%s, asal_sekolah=%s, tahun_lulus=%s, piagam_prestasi=%s, fc_raport=%s, ijasah=%s, skhun=%s, id_program_studi=%s, tempat_daftar=%s, tanggal_daftar=%s, mengetahui=%s, jalur=%s, status_hapus=%s, status_sah=%s, status_terima=%s, id_petugas=%s WHERE id_ppdb=%s",
                       GetSQLValueString($_POST['nomor_pendaftaran'], "text"),
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
                       GetSQLValueString($_POST['tanggal_daftar'], "date"),
                       GetSQLValueString($_POST['mengetahui'], "text"),
                       GetSQLValueString($_POST['jalur'], "text"),
                       GetSQLValueString(isset($_POST['status_hapus']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['status_sah']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['status_terima']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['id_petugas'], "int"),
                       GetSQLValueString($_POST['id_ppdb'], "int"));

  mysql_select_db($database_connect, $connect);
  $Result1 = mysql_query($updateSQL, $connect) or die(mysql_error());
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

$colname_ppdb_biodata = "-1";
if (isset($_GET['id_ppdb'])) {
  $colname_ppdb_biodata = $_GET['id_ppdb'];
}
mysql_select_db($database_connect, $connect);
$query_ppdb_biodata = sprintf("SELECT * FROM ppdb_biodata WHERE id_ppdb = %s", GetSQLValueString($colname_ppdb_biodata, "int"));
$ppdb_biodata = mysql_query($query_ppdb_biodata, $connect) or die(mysql_error());
$row_ppdb_biodata = mysql_fetch_assoc($ppdb_biodata);
$totalRows_ppdb_biodata = mysql_num_rows($ppdb_biodata);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Biodata</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="nav">
    <table width="73%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td><?php include('menu.php') ?></td>
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
      <td nowrap="nowrap" align="right">Nomor_pendaftaran:</td>
      <td><input type="text" name="nomor_pendaftaran" value="<?php echo htmlentities($row_ppdb_biodata['nomor_pendaftaran'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nama_lengkap:</td>
      <td><input type="text" name="nama_lengkap" value="<?php echo htmlentities($row_ppdb_biodata['nama_lengkap'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Jenis_kelamin:</td>
      <td><select name="jenis_kelamin">
        <option value="L" <?php if (!(strcmp("L", htmlentities($row_ppdb_biodata['jenis_kelamin'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Laki-Laki</option>
        <option value="P" <?php if (!(strcmp("P", htmlentities($row_ppdb_biodata['jenis_kelamin'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Perempuan</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id_agama:</td>
      <td><select name="id_agama">
        <?php 
do {  
?>
        <option value="<?php echo $row_ext_agama['id_agama']?>" <?php if (!(strcmp($row_ext_agama['id_agama'], htmlentities($row_ppdb_biodata['id_agama'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_ext_agama['nama']?></option>
        <?php
} while ($row_ext_agama = mysql_fetch_assoc($ext_agama));
?>
      </select></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tempat_lahir:</td>
      <td><input type="text" name="tempat_lahir" value="<?php echo htmlentities($row_ppdb_biodata['tempat_lahir'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tanggal_lahir:</td>
      <td><input type="text" name="tanggal_lahir" value="<?php echo htmlentities($row_ppdb_biodata['tanggal_lahir'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Alamat_rumah:</td>
      <td><input type="text" name="alamat_rumah" value="<?php echo htmlentities($row_ppdb_biodata['alamat_rumah'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Rt_rw:</td>
      <td><input type="text" name="rt_rw" value="<?php echo htmlentities($row_ppdb_biodata['rt_rw'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Kecamatan:</td>
      <td><input type="text" name="kecamatan" value="<?php echo htmlentities($row_ppdb_biodata['kecamatan'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Kabupaten:</td>
      <td><input type="text" name="kabupaten" value="<?php echo htmlentities($row_ppdb_biodata['kabupaten'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Kode_pos:</td>
      <td><input type="text" name="kode_pos" value="<?php echo htmlentities($row_ppdb_biodata['kode_pos'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">No_hp_calon_siswa:</td>
      <td><input type="text" name="no_hp_calon_siswa" value="<?php echo htmlentities($row_ppdb_biodata['no_hp_calon_siswa'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tinggi_badan:</td>
      <td><input type="text" name="tinggi_badan" value="<?php echo htmlentities($row_ppdb_biodata['tinggi_badan'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Berat_badan:</td>
      <td><input type="text" name="berat_badan" value="<?php echo htmlentities($row_ppdb_biodata['berat_badan'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Golongan_darah:</td>
      <td><select name="golongan_darah">
        <option value="A" <?php if (!(strcmp("A", htmlentities($row_ppdb_biodata['golongan_darah'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>A</option>
        <option value="B" <?php if (!(strcmp("B", htmlentities($row_ppdb_biodata['golongan_darah'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>B</option>
        <option value="AB" <?php if (!(strcmp("AB", htmlentities($row_ppdb_biodata['golongan_darah'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>AB</option>
        <option value="O" <?php if (!(strcmp("O", htmlentities($row_ppdb_biodata['golongan_darah'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>O</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nama_ayah_kandung:</td>
      <td><input type="text" name="nama_ayah_kandung" value="<?php echo htmlentities($row_ppdb_biodata['nama_ayah_kandung'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id_pekerjaan_ayah:</td>
      <td><select name="id_pekerjaan_ayah">
        <?php 
do {  
?>
        <option value="<?php echo $row_ext_pekerjaan_ayah['id_pekerjaan_ortu']?>" <?php if (!(strcmp($row_ext_pekerjaan_ayah['id_pekerjaan_ortu'], htmlentities($row_ppdb_biodata['id_pekerjaan_ayah'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_ext_pekerjaan_ayah['nama_pekerjaan']?></option>
        <?php
} while ($row_ext_pekerjaan_ayah = mysql_fetch_assoc($ext_pekerjaan_ayah));
?>
      </select></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nama_ibu_kandung:</td>
      <td><input type="text" name="nama_ibu_kandung" value="<?php echo htmlentities($row_ppdb_biodata['nama_ibu_kandung'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id_pekerjaan_ibu:</td>
      <td><select name="id_pekerjaan_ibu">
        <?php 
do {  
?>
        <option value="<?php echo $row_ext_pekerjaan_ibu['id_pekerjaan_ortu']?>" <?php if (!(strcmp($row_ext_pekerjaan_ibu['id_pekerjaan_ortu'], htmlentities($row_ppdb_biodata['id_pekerjaan_ibu'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_ext_pekerjaan_ibu['nama_pekerjaan']?></option>
        <?php
} while ($row_ext_pekerjaan_ibu = mysql_fetch_assoc($ext_pekerjaan_ibu));
?>
      </select></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">No_hp_orang_tua:</td>
      <td><input type="text" name="no_hp_orang_tua" value="<?php echo htmlentities($row_ppdb_biodata['no_hp_orang_tua'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Asal_sekolah:</td>
      <td><input type="text" name="asal_sekolah" value="<?php echo htmlentities($row_ppdb_biodata['asal_sekolah'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tahun_lulus:</td>
      <td><input type="text" name="tahun_lulus" value="<?php echo htmlentities($row_ppdb_biodata['tahun_lulus'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Piagam_prestasi:</td>
      <td><input type="checkbox" name="piagam_prestasi" value=""  <?php if (!(strcmp(htmlentities($row_ppdb_biodata['piagam_prestasi'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?> /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Fc_raport:</td>
      <td><input type="checkbox" name="fc_raport" value=""  <?php if (!(strcmp(htmlentities($row_ppdb_biodata['fc_raport'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?> /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Ijasah:</td>
      <td><input type="checkbox" name="ijasah" value=""  <?php if (!(strcmp(htmlentities($row_ppdb_biodata['ijasah'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?> /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Skhun:</td>
      <td><input type="checkbox" name="skhun" value=""  <?php if (!(strcmp(htmlentities($row_ppdb_biodata['skhun'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?> /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id_program_studi:</td>
      <td><select name="id_program_studi">
        <?php 
do {  
?>
        <option value="<?php echo $row_ext_program_studi['id_program_studi']?>" <?php if (!(strcmp($row_ext_program_studi['id_program_studi'], htmlentities($row_ppdb_biodata['id_program_studi'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_ext_program_studi['nama_studi']?></option>
        <?php
} while ($row_ext_program_studi = mysql_fetch_assoc($ext_program_studi));
?>
      </select></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tempat_daftar:</td>
      <td><input type="text" name="tempat_daftar" value="<?php echo htmlentities($row_ppdb_biodata['tempat_daftar'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tanggal_daftar:</td>
      <td><input type="text" name="tanggal_daftar" value="<?php echo htmlentities($row_ppdb_biodata['tanggal_daftar'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Mengetahui:</td>
      <td><input type="text" name="mengetahui" value="<?php echo htmlentities($row_ppdb_biodata['mengetahui'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Jalur:</td>
      <td><select name="jalur">
        <option value="REGULER" <?php if (!(strcmp("REGULER", htmlentities($row_ppdb_biodata['jalur'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>REGULER</option>
        <option value="PRESTASI" <?php if (!(strcmp("PRESTASI", htmlentities($row_ppdb_biodata['jalur'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>PRESTASI</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Status_hapus:</td>
      <td><input type="checkbox" name="status_hapus" value=""  <?php if (!(strcmp(htmlentities($row_ppdb_biodata['status_hapus'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?> /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Status_sah:</td>
      <td><input type="checkbox" name="status_sah" value=""  <?php if (!(strcmp(htmlentities($row_ppdb_biodata['status_sah'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?> /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Status_terima:</td>
      <td><input type="checkbox" name="status_terima" value=""  <?php if (!(strcmp(htmlentities($row_ppdb_biodata['status_terima'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?> /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="id_petugas" value="<?php echo htmlentities($row_ppdb_biodata['id_petugas'], ENT_COMPAT, 'utf-8'); ?>" />
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_ppdb" value="<?php echo $row_ppdb_biodata['id_ppdb']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($ext_agama);

mysql_free_result($ext_pekerjaan_ibu);

mysql_free_result($ext_pekerjaan_ayah);

mysql_free_result($ext_program_studi);

mysql_free_result($ppdb_biodata);
?>
