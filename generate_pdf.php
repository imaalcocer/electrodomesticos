<?php
require('fpdf/fpdf.php');

class PDF extends FPDF {
    // Cabecera de página
    function Header() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Reporte', 0, 1, 'C');
        $this->Ln(10);
    }

    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }

    // Tabla de datos
    function FancyTable($header, $data) {
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');

        // Cabecera
        $w = array(10, 30, 30, 50, 30, 50, 30);
        foreach ($header as $i => $col)
            $this->Cell($w[$i], 7, $col, 1, 0, 'C', true);
        $this->Ln();

        // Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');

        // Datos
        $fill = false;
        foreach ($data as $row) {
            foreach ($header as $i => $col) {
                $value = isset($row[$i]) ? $row[$i] : 'N/A';
                $this->Cell($w[$i], 6, $value, 'LR', 0, 'L', $fill);
            }
            $this->Ln();
            $fill = !$fill;
        }

        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['data']) && isset($_POST['type'])) {
        $data = json_decode($_POST['data'], true);
        $type = $_POST['type'];

        // Verificar que los datos no estén vacíos
        if (empty($data)) {
            die('No data to display.');
        }

        $pdf = new PDF();
        $pdf->SetFont('Arial', '', 14);
        $pdf->AddPage();

        if ($type === 'users') {
            $header = array('ID', 'Nombre', 'Apellido', 'Email', 'Avatar');
        } else if ($type === 'productos') {
            $header = array('ID', 'Color', 'Modelo', 'Componentes', 'Precio', 'Marca ID', 'Imagen');
        } else if ($type === 'marcas') {
            $header = array('ID', 'Nombre');
        }

        // Debug: mostrar los datos que se están pasando
        error_log('Data: ' . print_r($data, true));
        error_log('Header: ' . print_r($header, true));

        $pdf->FancyTable($header, $data);
        $pdf->Output();
    } else {
        echo "No data received.";
    }
} else {
    echo "Invalid request method.";
}
?>
