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
  $updateSQL = sprintf("UPDATE ppdb_nilai SET id_ppdb=%s, mapel_matematika=%s, mapel_bindonesia=%s, mapel_binggris=%s, mapel_ilmupengetahuanalam=%s, total_nilai=%s, sah=%s, status=%s WHERE id_ppdb_nilai=%s",
                       GetSQLValueString($_POST['id_ppdb'], "int"),
                       GetSQLValueString($_POST['mapel_matematika'], "double"),
                       GetSQLValueString($_POST['mapel_bindonesia'], "double"),
                       GetSQLValueString($_POST['mapel_binggris'], "double"),
                       GetSQLValueString($_POST['mapel_ilmupengetahuanalam'], "double"),
                       GetSQLValueString($_POST['total_nilai'], "double"),
                       GetSQLValueString(isset($_POST['sah']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['status']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['id_ppdb_nilai'], "int"));

  mysql_select_db($database_connect, $connect);
  $Result1 = mysql_query($updateSQL, $connect) or die(mysql_error());
  
        $updateGoTo = "tampil_nilai.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
	  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_ppdb_nilai = "-1";
if (isset($_GET['id'])) {
  $colname_ppdb_nilai = $_GET['id'];
}
mysql_select_db($database_connect, $connect);
$query_ppdb_nilai = sprintf("SELECT * FROM ppdb_nilai WHERE id_ppdb_nilai = %s", GetSQLValueString($colname_ppdb_nilai, "int"));
$ppdb_nilai = mysql_query($query_ppdb_nilai, $connect) or die(mysql_error());
$row_ppdb_nilai = mysql_fetch_assoc($ppdb_nilai);
$totalRows_ppdb_nilai = mysql_num_rows($ppdb_nilai);$colname_ppdb_nilai = "-1";
if (isset($_GET['id'])) {
  $colname_ppdb_nilai = $_GET['id'];
}
mysql_select_db($database_connect, $connect);
$query_ppdb_nilai = sprintf("SELECT * FROM ppdb_nilai WHERE id_ppdb = %s", GetSQLValueString($colname_ppdb_nilai, "int"));
$ppdb_nilai = mysql_query($query_ppdb_nilai, $connect) or die(mysql_error());
$row_ppdb_nilai = mysql_fetch_assoc($ppdb_nilai);
$totalRows_ppdb_nilai = mysql_num_rows($ppdb_nilai);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Nilai</title>
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
      <td nowrap="nowrap" align="right">Id_ppdb:</td>
      <td><input type="text" name="id_ppdb" value="<?php echo htmlentities($row_ppdb_nilai['id_ppdb'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Mapel_matematika:</td>
      <td><input type="text" name="mapel_matematika" value="<?php echo htmlentities($row_ppdb_nilai['mapel_matematika'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Mapel_bindonesia:</td>
      <td><input type="text" name="mapel_bindonesia" value="<?php echo htmlentities($row_ppdb_nilai['mapel_bindonesia'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Mapel_binggris:</td>
      <td><input type="text" name="mapel_binggris" value="<?php echo htmlentities($row_ppdb_nilai['mapel_binggris'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Mapel_ilmupengetahuanalam:</td>
      <td><input type="text" name="mapel_ilmupengetahuanalam" value="<?php echo htmlentities($row_ppdb_nilai['mapel_ilmupengetahuanalam'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Total_nilai:</td>
      <td><input type="text" name="total_nilai" value="<?php echo htmlentities($row_ppdb_nilai['total_nilai'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Sah:</td>
      <td><input type="checkbox" name="sah" value=""  <?php if (!(strcmp(htmlentities($row_ppdb_nilai['sah'], ENT_COMPAT, 'utf-8'),1))) {echo "checked=\"checked\"";} ?> /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Status:</td>
      <td><input type="checkbox" name="status" value=""  <?php if (!(strcmp(htmlentities($row_ppdb_nilai['status'], ENT_COMPAT, 'utf-8'),0))) {echo "checked=\"checked\"";} ?> /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Simpan" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_ppdb_nilai" value="<?php echo $row_ppdb_nilai['id_ppdb_nilai']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($ppdb_nilai);
?>
