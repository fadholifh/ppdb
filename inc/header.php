<?php //require_once('../inc/auth.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<ul id="MenuBar1" class="MenuBarHorizontal">
  <li><a class="MenuBarItemSubmenu" href="#">Input Data</a>
    <ul>
      <li><a href="../panel/input_biodata.php">Biodata</a></li>
      <li><a href="../panel/input_nilai_pertama.php">Nilai</a></li>
      <li><a href="../panel/input_nilai.php">Prestasi</a></li>
    </ul>
  </li>
  <li><a href="#" class="MenuBarItemSubmenu">Data</a>
    <ul>
      <li><a href="../panel/tampil_biodata.php">Biodata</a></li>
      <li><a href="../panel/tampil_nilai.php">Nilai</a></li>
      <li><a href="../panel/tampil_prestasi.php">Prestasi</a></li>
</ul>
  </li>
  <li><a class="MenuBarItemSubmenu" href="#">Konfigurasi</a>
    <ul>
      <li><a href="../panel/tampil_agama.php">Agama</a>      </li>
      <li><a href="../panel/tampil_pekerjaan_ortu.php">Pekerjaan Ortu</a></li>
      <li><a href="../panel/tampil_program_studi.php">Program Studi</a></li>
    </ul>
  </li>
  <li><a href="#" class="MenuBarItemSubmenu">Laporan</a>
    <ul>
      <li><a href="../jurnal/index.php">Jurnal</a></li>
      <li><a href="../panel/cetak_pertama.php">Pdf</a></li>
      <li><a href="../panel/report_akhir_pertama.php">Html</a></li>
    </ul>
  </li>
  <li><a href="#" class="MenuBarItemSubmenu">User</a>
    <ul>
      <li><a href="../panel/input_user.php">Tambah User</a></li>
      <li><a href="../panel/edit_user.php">Edit User</a></li>
      <li><a href="../panel/tampil_user.php">Tampil User</a></li>
    </ul>
  </li>
  <li><a href="../logout.php">Logout</a></li>
</ul>
<br/><br/>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"../SpryAssets/SpryMenuBarDownHover.gif", imgRight:"../SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>