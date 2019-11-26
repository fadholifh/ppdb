<?php
    require_once('../inc/html2fpdf/html2pdf.class.php');
?>
<?php
	// get the HTML
    ob_start();
    include(dirname(__FILE__).'/cetak_isi.php');
    $content = ob_get_clean();
	
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('exemple.pdf');
	//echo $content;
?>