<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', error_reporting(E_ALL));
require('fpdf/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
    function Header()
    {

        // Arial bold 15
        $this->SetFont('Arial', 'B', 16);
        // Movernos a la derecha
        $this->Cell(60);
        // Título
        $this->Cell(150, 10, 'Informe de Servicios ', 0, 0, 'C');
        // Salto de línea
        $this->Ln(20);

        $this->Cell(55, 10, 'Id Servicio', 1, 0, 'C', 0);
        $this->Cell(55, 10, utf8_decode('Id Categoría'), 1, 0, 'C', 0);
        $this->Cell(55, 10, utf8_decode('Fecha publicación'), 1, 0, 'C', 0);
        $this->Cell(55, 10, 'Precio', 1, 0, 'C', 0);
        $this->Cell(55, 10, 'Id Usuario', 1, 1, 'C', 0);

    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, utf8_decode('Página') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}