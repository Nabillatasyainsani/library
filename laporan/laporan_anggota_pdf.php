<?php
require_once('tcpdf/tcpdf.php'); // Pastikan jalur ke TCPDF benar

// Buat instance TCPDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Konten HTML
$content = "
<h1>Exemple d'utilisation</h1>
<p>Ceci est un exemple d'utilisation de <a href='http://www.fpdf.org'>FPDF</a>.</p>
";

// Tulis HTML ke PDF
$pdf->writeHTML($content, true, false, true, false, '');

// Output file PDF
$pdf->Output('exemple.pdf', 'D'); // 'D' untuk unduh langsung
?>
