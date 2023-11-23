<?php
    session_start();
    if ($_SESSION['URL_Net']=="Respondio Exitosamente Todo"){

        require('fpdf.php');
        require_once('qrcode/qrcode.class.php');


        class PDF extends FPDF
        {
            private $backgroundImage = 'fondo.png';

            // C
            function Header()
            {
                // Logo ITP
                $this->Image('logoitp.png', 10, 8, 50); // Ajusta el ancho del logo ITP

                // Logo MINEDU al lado del logo ITP
                $this->Image('logominedu.png', 70, 8, 50); // Ajusta la posición y el ancho del logo MINEDU

                // Arial bold 15
                $this->SetFont('Arial', 'B', 15);
                // Movernos a la derecha
                $this->Cell(80);
                // Título
                $this->Cell(30, 10, 'Title', 1, 0, 'C');
                // Salto de línea
                $this->Ln(20);
            }

            // Pie de página
            function Footer()
            {
                // Establecer las coordenadas en la esquina superior izquierda
                $this->SetXY(0, 0);

                // Agregar la imagen de fondo en el pie de página
                $this->Image($this->backgroundImage, 0, 0, $this->w, $this->h);

                // Logo ITP encima del fondo
                $this->Image('logoitp.png', 55, 17, 80); // Ajusta el ancho del logo ITP

                // Logo MINEDU al lado del logo ITP en el pie de página
                $this->Image('logominedu.png', 140, 18, 100); // Ajusta la posición y el ancho del logo MINEDU
                $this->SetFont('Arial', 'B', 35);
                $this->SetY($this->h / 2 - 40); // Posiciona en el centro vertical restando la mitad de la altura del texto
                $this->Cell(0, 0, 'INSTITUTO TECNOLOGICO DEL PUTUMAYO', 0, 1, 'C');
                
                $this->SetFont('Arial', 'B', 25);
                $this->SetY($this->h / 2 - 19); // Posiciona en el centro vertical restando la mitad de la altura del texto
                $this->Cell(0, 0, utf8_decode('Certifica la Participación en la Evaluación Docente a:'), 0, 1, 'C');


                $this->SetFont('Arial', 'B', 30);
                $this->SetY($this->h / 2 - -2); // Posiciona en el centro vertical restando la mitad de la altura del texto
                $this->Cell(0, 0, utf8_decode($_SESSION['User_Name']), 0, 1, 'C');

                $this->SetFont('Arial', '', 16);
                $this->SetY($this->h / 2 - -10); // Posiciona en el centro vertical restando la mitad de la altura del texto
                $this->Cell(0, 0, utf8_decode('C.C. '.$_SESSION['User_UserName']), 0, 1, 'C');


                $text = "El documento certifica la participación activa en la ".$_SESSION['QuesEvaName'].". La retroalimentación proporcionada contribuye al desarrollo profesional de los docentes y a la mejora continua de los métodos de enseñanza. Agradecemos sinceramente su valiosa contribución a la calidad educativa. Este certificado se emite en ". date('d/m/Y');

                $this->SetFont('Arial', '', 16);
                $this->SetFillColor(255, 255, 255); // Fondo blanco
                $this->SetXY(44, -85); // Ajusta las coordenadas X e Y según sea necesario
                $this->MultiCell(210, 7, utf8_decode($text), 0, 'J', true); // Ajusta el ancho según sea necesario, 'J' para justificar, 'true' para rellenar

                $this->Image('firmaViceAcad.png', 114, 162, 70); // Ajusta la posición y el ancho del logo MINEDU

                $this->SetFont('Arial', 'B', 15);
                $this->SetY($this->h / 2 - -80); // Posiciona en el centro vertical restando la mitad de la altura del texto
                $this->Cell(0, 0, utf8_decode('Nilsa Andrea Silva Castillo'), 0, 1, 'C');

                $this->SetFont('Arial', 'B', 15);
                $this->SetY($this->h / 2 - -85); // Posiciona en el centro vertical restando la mitad de la altura del texto
                $this->Cell(0, 0, utf8_decode('Vicerrectora Académica'), 0, 1, 'C');

                // Generar código QR
                $url = $_SESSION['User_Name']." - ".$_SESSION['User_UserName']." - ".$_SESSION['QuesEvaName'];  // Reemplaza con la URL que desees
                $qrcode = new QRcode($url, 'L');
                $qrcode->displayFPDF($this, 10, 10, 40);

                $this->SetFont('Arial', '', 12);


                // Posición: a 1,5 cm del final
                $this->SetY(-15);
                // Arial italic 8
                $this->SetFont('Arial', 'I', 8);
                // Número de página
                //$this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');

                
            }
        }

        $pdf = new PDF('L'); // 'L' indica orientación horizontal
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times', '', 12);

        for ($i = 1; $i <= 5; $i++) {
            $pdf->Cell(0, 10, 'Imprimiendo línea número ' . $i, 0, 1);
        }

        $pdf->Output();
    }else{
        header("Location: ../../../");

    }
?>
