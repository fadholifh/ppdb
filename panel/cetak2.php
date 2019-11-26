<?php
require_once('../inc/html2fpdf/html2pdf.class.php');
	$content = '<page>
	
	<img src="http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/barcode.php?text=11111">
	</page>';
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('exemple.pdf');

?>