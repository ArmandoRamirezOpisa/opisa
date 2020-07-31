<?php

include ('../../include/local_dsn.php');
include ('../../include/dsn.php');
include ('../pdf/fpdf.php');


class PDF extends FPDF
{
	//Cabecera de página
	function Header()
	{		
		$fecha= Date("d\-m\-Y"); 
		//Logo
		$this->Image('../img/logoA.png',10,8,33);
		//Arial bold 15
		$this->SetFont('Arial','B',15);
		//Movernos a la derecha
		$this->Cell(40);
	    //Título
		$this->Cell(30,8,'Participantes Registrados',0,0);
		$this->Ln();
		$this->SetFont('Arial','B',8);
		$this->Cell(40);
		$this->Cell(30,5,'Fecha de consulta: '.$fecha,0,0);
		//Salto de línea
		$this->Ln(5);
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


	function tabla($cab)
	{
		//Colores, ancho de línea y fuente en negrita
    
    //$this->SetTextColor(255);
    //$this->SetDrawColor(128,0,0);
    //$this->SetLineWidth(.3);
    //$this->SetFont('','B');

		$c=$_GET['con'];
		if ($c==0){
			$sql ="SELECT id,usuario,mail,telefono,nombre,calle,colonia,ciudad,cp,estado,fhalta,saldo,pwd FROM t8IpartWeb ORDER BY id desc";
		}else if ($c==1){
			$sql ="SELECT id,usuario,mail,telefono,nombre,calle,colonia,ciudad,cp,estado,fhalta,saldo,pwd FROM t8IpartWeb ORDER BY usuario";
		}else if ($c==2){
			$sql ="SELECT id,usuario,mail,telefono,nombre,calle,colonia,ciudad,cp,estado,fhalta,saldo,pwd FROM t8IpartWeb ORDER BY usuario desc";
		}else if ($c==3){
			$sql ="SELECT id,usuario,mail,telefono,nombre,calle,colonia,ciudad,cp,estado,fhalta,saldo,pwd FROM t8IpartWeb ORDER BY nombre";
		}else if ($c==4){
			$sql ="SELECT id,usuario,mail,telefono,nombre,calle,colonia,ciudad,cp,estado,fhalta,saldo,pwd FROM t8IpartWeb ORDER BY nombre desc";
		}else if ($c==5){
			$sql ="SELECT id,usuario,mail,telefono,nombre,calle,colonia,ciudad,cp,estado,fhalta,saldo,pwd FROM t8IpartWeb ORDER BY saldo";
		}else if ($c==6){
			$sql ="SELECT id,usuario,mail,telefono,nombre,calle,colonia,ciudad,cp,estado,fhalta,saldo,pwd FROM t8IpartWeb ORDER BY saldo desc";
		}else if ($c==7){
			$sql ="SELECT id,usuario,mail,telefono,nombre,calle,colonia,ciudad,cp,estado,fhalta,saldo,pwd FROM t8IpartWeb ORDER BY fhalta";
		}else if ($c==8){
			$sql ="SELECT id,usuario,mail,telefono,nombre,calle,colonia,ciudad,cp,estado,fhalta,saldo,pwd FROM t8IpartWeb ORDER BY fhalta desc";
		}		
		$res = mysql_query($sql) or die ('Error al Consultar Participantes - Part'.mysql_error());
		
		while($row=mysql_fetch_array($res))
		{
			//Cabecera
			$this->SetFillColor(255,0,0);			
            $this->SetTextColor(39,64,139);
		    $this->SetFont('','B');

			$this->Cell(20,3,$cab[0],1,0,'C');
			$this->Cell(50,3,$cab[1],1,0,'C');
			$this->Cell(60,3,$cab[2],1,0,'C');
			$this->Cell(20,3,$cab[3],1,0,'C');
			$this->Cell(50,3,$cab[4],1,0,'C');
			$this->Cell(50,3,$cab[5],1,0,'C');
			$this->Ln();

			$this->SetFillColor(255,255,255);		
            $this->SetTextColor(0);
			$this->SetFont('');

			$this->Cell(20,3,$row['usuario'],1,0);
			$this->Cell(50,3,$row['nombre'],1,0);
			$this->Cell(60,3,$row['mail'],1,0);
			$this->Cell(20,3,$row['telefono'],1,0);
			$this->Cell(50,3,$row['calle'],1,0);
			$this->Cell(50,3,$row['colonia'],1,0);
			$this->Ln();

			$this->SetFillColor(30,144,255);		
            $this->SetTextColor(39,64,139);
            $this->SetFont('','B');

			$this->Cell(50,3,$cab[6],1,0,'C');
			$this->Cell(10,3,$cab[7],1,0,'C');
			$this->Cell(30,3,$cab[8],1,0,'C');
			$this->Ln();

			$this->SetFillColor(255,255,255);	
            $this->SetTextColor(0);
			$this->SetFont('');

			$this->Cell(50,3,$row['ciudad'],1,0);
			$this->Cell(10,3,$row['cp'],1,0);
			$this->Cell(30,3,$row['estado'],1,0);
			$this->Ln();
			$this->Ln();
		}
	}

}

//Creación del objeto de la clase heredada
$pdf=new PDF('L','mm','LETTER');

//Títulos de las columnas
$cab=array('USUARIO','NOMBRE','E-MAIL','TELÉFONO','CALLE','COLONIA','CIUDAD','C.P.','ESTADO');

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',7);
$pdf->tabla($cab);
$pdf->Output();


?>