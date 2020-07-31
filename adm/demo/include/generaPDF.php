<?php

include ('../pdf/fpdf.php');


class PDF extends FPDF
{
	//Cabecera de página
	function Header()
	{
		//Logo
		$this->Image('../img/logoA.png',10,8,33);
		//Arial bold 15
		$this->SetFont('Arial','B',15);
		//Movernos a la derecha
		$this->Cell(80);
	    //Título
		$this->Cell(30,10,'Participantes Registrados',0,0,'C');
		//Salto de línea
		$this->Ln(20);
	}

	//Pie de página
	function Footer()
	{
		 //Posición: a 1,5 cm del final
		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','I',8);
		 //Número de página
		$this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
	}


	function tabla($cab,$sql)
	{
		//Cabecera
		$this->Cell(20,5,$cab[0],1,0,'C');
		$this->Cell(50,5,$cab[1],1,0,'C');
		$this->Cell(50,5,$cab[2],1,0,'C');
		$this->Cell(20,5,$cab[3],1,0,'C');
		$this->Cell(50,5,$cab[4],1,0,'C');
		$this->Cell(50,5,$cab[5],1,0,'C');
		$this->Cell(50,5,$cab[6],1,0,'C');
		$this->Ln();
		$this->Ln();
		$this->Cell(10,5,$cab[7],1,0,'C');
		$this->Cell(30,5,$cab[8],1,0,'C');
		$this->Ln();
	}

}

//Creación del objeto de la clase heredada
$pdf=new PDF('L','mm','LETTER');

//Títulos de las columnas
$cab=array('Usuario','Nombre','E-mail','Teléfono','Calle','Colonia','Ciudad','C.P.','Estado');

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',8);
$pdf->tabla($cab,$sq);
$pdf->Output();


?>