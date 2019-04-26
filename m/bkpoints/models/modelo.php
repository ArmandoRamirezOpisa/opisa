<?php
	include("../../include/local_dsn.php");
	include("../../include/dsn.php");
    
  $_SESSION['programa']=32;
    
	function catePremio()
	{    
	   if(substr_count($_SESSION['cargo'],'gerente')==1){
	       $atp="";	 
	   }else{
	       $atp=" AND stAtipico=0";       
	   }
		$sSql="SELECT distinct(cp.nbCategoria) as nbCategoria,cp.CodCategoria  ";
		$sSql.="FROM t213kpCategoriaPremio cp LEFT JOIN Premio p ON p.codCategoria = cp.codCategoria ";
		$sSql.="WHERE cp.esBaja=0 AND p.codPremio in (SELECT codPremio FROM PremioPrograma WHERE codPrograma = ".$_SESSION['programa'].$atp.") ORDER BY cp.nbCategoria";
        
		$res = mysql_query($sSql) or die ('La consulta fallo-CAT;: ' .mysql_error());
		return $res;
	}
    
    function premios($idCat)
    {	   
        if (!eregi('gerente',$_SESSION['cargo'])){
	       $atp=" AND pp.stAtipico=0";
        }else{
	       $atp="";	       
	    }
                
        $crit='p.CodCategoria';
        $sSql="SELECT DISTINCT(p.codPremio) as codPremio,p.Nombre_Esp,p.Caracts_Esp,pp.ValorPuntos,p.codCategoria ";
		$sSql.="FROM Premio p 
                INNER JOIN PremioPrograma pp ON pp.codPremio = p.codPremio ";
		$sSql.="WHERE pp.codPrograma = ".$_SESSION['programa']." AND ".$crit." = ".$idCat.$atp." 
                ORDER BY pp.ValorPuntos DESC,p.codPremio";
                
  		$res = mysql_query($sSql) or die ('La consulta fallo-PRE;: ' .mysql_error());
		return $res;
    }
    
    function login($form)
    {
        $rClaveEmp=substr($form['cve'],0,5);
    	$rClavePart=substr($form['cve'],5,3);
        $sql="SELECT p.idParticipante,p.codEmpresa,p.codParticipante,p.Cargo,p.PrimerNombre,p.ApellidoPaterno,
                     p.saldoActual 
                FROM Participante p
                INNER JOIN t10IClavesPartWeb w ON w.idParticipante = p.idParticipante
                AND w.codPrograma = p.codprograma
                WHERE p.status=1 and p.codPrograma =".$_SESSION['programa']."
                AND p.codEmpresa =".$rClaveEmp."
                AND codParticipante =".$rClavePart."
                AND w.pwd='".$form['pwd']."'";
            $res=mysql_query($sql);     
        if (mysql_num_rows($res)<1)
        {
            $sql="SELECT * FROM Participante 
            WHERE codEmpresa=".$rClaveEmp." AND codParticipante=".$rClavePart." 
            AND codPrograma=".$_SESSION['programa']." AND pwd='".$form['pwd']."'"; 
            $res=mysql_query($sql);   
            if (mysql_num_rows($res)<1)
            {
                return false;
            }else{
                $row=mysql_fetch_array($res);
                $_SESSION['chPass']=0;                            
                $_SESSION['id']=$row['idParticipante'];               
                $_SESSION['cargo']=strtolower($row['Cargo']);
                return $row;
            }          
        }else{
            $row=mysql_fetch_array($res);
            $_SESSION['chPass']=1;
            return $row;
        }           
    }
    
    function verificaPassword($idPart)
    {
        $sql="SELECT * 
               FROM t10IClavesPartWeb 
                WHERE idParticipante =".$idPart;
        $res=mysql_query($sql);
        if (mysql_num_rows($res)<1)
        {
            return 1;
        }else{
            return 2;
        }                              
    }
    
    function gPass($form){
        $ip =ip_vis();
        $sql="INSERT INTO t10IClavesPartWeb 
               (idParticipante,pwd,codPrograma,acReglas,ip,fhAcepta)
              VALUES (".$_SESSION['id'].",'".$form['pwd']."',".$_SESSION['programa'].",1,'".$ip."',curdate())";
        if(mysql_query($sql)){
            return true;
        }else{
            return false;
        }
    }
    
    function datos_empresa()
    {
    	$sql="SELECT * 
    				FROM Empresa 
    				WHERE codPrograma =".$_SESSION['programa']." AND codEmpresa =".$_SESSION['emp'];
    	$res=mysql_query($sql);
    	$row=mysql_fetch_array($res);
    	return $row;    	
    }
    
    function insertaCanje($rowEmp)
    {
    	$ip =ip_vis();
    	$folio=sigFolio();
    	$sql="INSERT INTO PreCanje
    				(codPrograma,idParticipante,noFolio,feSolicitud,noIP,noTipoEntrega,CalleNumero,Colonia,CP,Ciudad,Estado,Telefono)
    				VALUES (".$_SESSION['programa'].",".$_SESSION['id'].",".$folio.",curdate(),'".$ip."',1,'".$rowEmp['CalleNumero']."',
    				        '".$rowEmp['Colonia']."','".$rowEmp['CP']."','".$rowEmp['Ciudad']."','".$rowEmp['Estado']."','".$rowEmp['Telefono']."')";
    	$res = mysql_query($sql) or die ('La consulta fallo-InsCanj;: ' .mysql_error()); 
    	//return mysql_insert_id();
    	return $folio;
    }
    
    function sigFolio()
    {
				$sSql="SELECT MAX(noFolio)+1 as mFolio FROM PreCanje";	    
				$res = mysql_query($sSql) or die ('La consulta fallo-SigFol;: ' .mysql_error());         
				$f= mysql_fetch_array($res);
				return $f['mFolio'];
    }
    
    function insertaDetalle($folC)
    {

			foreach($_SESSION['act_car'] as $key)
			{			
				$sSql = "SELECT MAX(idPreCanjeDet) as MidF FROM PreCanjeDet WHERE noFolio = ".$folC;
				$res = mysql_query($sSql) or die ('La consulta fallo-InsDet;: ' .mysql_error());         
				$f= mysql_fetch_array($res);
				  
				if ($f['MidF']==0) 
				{
					$idFolDet=1;
				}else{
					$idFolDet=$f['MidF']+1;
				}
	    	
				$sSql = "INSERT INTO PreCanjeDet (idParticipante,noFolio,idPreCanjeDet,codPremio,Cantidad,PuntosXUnidad) ";
				$sSql.="SELECT ".$_SESSION['id'].",".$folC.",".$idFolDet.",".$key[0].",".$key[1].",".$key[2];
			  $res = mysql_query($sSql) or die ('La consulta fallo-InsPreCanDet;: ' .mysql_error());         
				@mysql_fetch_array($res); 
				$ptsTot+=$key[1]*$key[2];
			} 			
			return $ptsTot;
    }
    
    function actualizaSaldo($ptsTot)
    {
        if ($_SESSION['sant']==0)
        { 
            $sSql="UPDATE Participante SET SaldoActual = SaldoActual - ".$ptsTot." WHERE idParticipante =".$_SESSION['id'];	
            $res = mysql_query($sSql) or die ('La consulta fallo-acts;: ' .mysql_error());         
    		@mysql_fetch_array($res); 
    		$_SESSION['saldo']-=$ptsTot;
        }else{                
            actualizaSaldoAnt($ptsTot);
        }
    }

    function verificaTrivia()
    {
    	$sql="SELECT * 
    				FROM t5InRespTrivias 
    				WHERE idParticipante=".$_SESSION['id']." AND codPrograma =".$_SESSION['programa']."
    				AND idPregunta IN (SELECT id FROM t4InTrivias WHERE idBloque=".$_SESSION['trivia'].")";
    	$res=mysql_query($sql);
    	if (mysql_num_rows($res)==0)
    	{
    		return false;
    	}else{
    		return true;
    	}
    }
    
    function guardaTrivia($form,$noElements)
    {
    	$resp = new xajaxResponse();
    	$sql="SELECT id FROM t4InTrivias WHERE codPrograma=".$_SESSION['programa']." AND idBloque=".$_SESSION['trivia']." ORDER BY id";
    	$res=mysql_query($sql);
    	while($row=mysql_fetch_array($res))
    	{
    		if (strlen($form[$row['id']])>0)
    		{
	    		$sql="INSERT INTO t5InRespTrivias (idParticipante,rAbierta,idPregunta,fhRespuesta,codPrograma)
	    					VALUES (".$_SESSION['id'].",'".quitaAcento($form[$row['id']])."',".$row['id'].",curdate(),".$_SESSION['programa'].")";
	    		@mysql_query($sql) or die ("Error al guardar respuestas. ".mysql_error());
	    	}
    	}
			$salida=inicio();
    	$resp->addAlert("Las respuestas han sido guardadas."); 	
      $resp->addAssign("principal","innerHTML",$salida);
      
    	return $resp;
    }

    function calculaSaldo()
    {
        if ($_SESSION['sant']==0)
        {
    		//Fecha del día de Hoy
        	$hoy=date("Y-m-d");    	
        	//Verifica la fecha de actualización de la base de datos
        	$sql="SELECT SUM(d.PuntosXUnidad*d.Cantidad) as puntosPend
        					FROM PreCanje c
        					INNER JOIN PreCanjeDet d ON d.noFolio=c.noFolio AND d.idParticipante=c.idParticipante  
        					WHERE c.esExportado=0 AND c.idParticipante = ".$_SESSION['id']." AND c.codPrograma=".$_SESSION['programa']; 
        	$res=mysql_query($sql) or die ("Error al consultar Canjes Pendientes". mysql_error());
        	if (mysql_num_rows($res)>0)
        	{
        	 $row=mysql_fetch_array($res);
        	 return $_SESSION['saldo'] - $row['puntosPend'];
        	}else{
        		return 0;
        	}
        }else{
            return saldoAnoPass();
        }
    }
    
    function saldoAnoPass()
    {        
        $sql="SELECT saldo 
                FROM t11ISaldoAnterior 
                WHERE codEmpresa=".$_SESSION['emp']." AND codParticipante=".$_SESSION['part'];  
        $res=mysql_query($sql);
        $row=mysql_fetch_array($res);
        return $row["saldo"];      
    }
    
    function actualizaSaldoAnt($monto)
    {
        $sql="UPDATE t11ISaldoAnterior 
                set saldo=saldo-".$monto." 
              WHERE codEmpresa=".$_SESSION['emp']." AND codParticipante=".$_SESSION['part']; 
        @mysql_query($sql);
    }

?>