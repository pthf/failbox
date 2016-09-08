<?php 
	require_once("../db/conexion.php");
	
	    date_default_timezone_set('America/Mexico_City');

	    if (PHP_SAPI == 'cli')
	        die('Este archivo solo se puede ver desde un navegador web');

	    /** Se agrega la libreria PHPExcel */
	    require_once '../php/lib/PHPExcel/PHPExcel.php';

	    // Se crea el objeto PHPExcel
	    $objPHPExcel = new PHPExcel();

	    // Se asignan las propiedades del libro
	    $objPHPExcel->getProperties()->setCreator("Failbox") //Autor
	                         ->setLastModifiedBy("Failbox") //Ultimo usuario que lo modificó
	                         ->setTitle("Listado Productos")
	                         ->setSubject("Carga Masiva")
	                         ->setDescription("Tablas necesarias para los productos")
	                         ->setKeywords("reporte productos")
	                         ->setCategory("Reporte excel");

	    $tituloReporte = "Ultimos Productos Agregados Failbox";
	    $titulosColumnas = array('IDPRODUCTO', 'NombreProd');

	    $objPHPExcel->setActiveSheetIndex(0)
	                ->mergeCells('D1:E1');

	    // Se agregan los titulos del reporte
	    $objPHPExcel->setActiveSheetIndex(0)
	                ->setCellValue('D1',$tituloReporte)
	                ->setCellValue('D2',  $titulosColumnas[0])
	                ->setCellValue('E2',  $titulosColumnas[1]);

	    //Se agregan los datos de los Productos
	    $limite_id = $_GET['total_ids'];
	    $query6 = "SELECT * FROM Productos ORDER BY IdProducto DESC LIMIT $limite_id";
	    $resultado6 = mysql_query($query6,Conectar::con()) or die(mysql_error());
	    $i = 4;
	    while ($fila = mysql_fetch_array($resultado6)) {
	        $objPHPExcel->setActiveSheetIndex(0)
	                ->setCellValue('D'.$i, $fila['IdProducto'])
	                ->setCellValue('E'.$i, $fila['NombreProd']);
	                $i++;
	    }
	    $estiloTituloReporte = array(
	        'font' => array(
	            'name'      => 'Verdana',
	            'bold'      => true,
	            'italic'    => false,
	            'strike'    => false,
	            'size' =>16,
	                'color'     => array(
	                    'rgb' => 'FFFFFF'
	                )
	        ),
	        'fill' => array(
	            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
	            'color' => array('argb' => 'FF220835')
	        ),
	        'borders' => array(
	            'allborders' => array(
	                'style' => PHPExcel_Style_Border::BORDER_NONE                    
	            )
	        ), 
	        'alignment' =>  array(
	                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	                'rotation'   => 0,
	                'wrap'          => TRUE
	        )
	    );

	    $estiloTituloColumnas = array(
	        'font' => array(
	            'name'      => 'Arial',
	            'bold'      => true,                          
	            'color'     => array(
	                'rgb' => '000000'
	            )
	        ),
	        'fill'  => array(
	            'type'      => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
	            'rotation'   => 90,
	            'startcolor' => array(
	                'rgb' => 'FFFFFF'
	            ),
	            'endcolor'   => array(
	                'argb' => 'FFFFFF'
	            )
	        ),
	        'borders' => array(
	            'top'     => array(
	                'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
	                'color' => array(
	                    'rgb' => 'FFFFFF'
	                )
	            ),
	            'bottom'     => array(
	                'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
	                'color' => array(
	                    'rgb' => 'FFFFFF'
	                )
	            )
	        ),
	        'alignment' =>  array(
	                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	                'wrap'          => TRUE
	        ));
	        
	    $estiloInformacion = new PHPExcel_Style();
	    $estiloInformacion->applyFromArray(
	        array(
	            'font' => array(
	            'name'      => 'Arial',               
	            'color'     => array(
	                'rgb' => '000000'
	            )
	        ),
	        'fill'  => array(
	            'type'      => PHPExcel_Style_Fill::FILL_SOLID,
	            'color'     => array('rgb' => 'FFFFFF')
	        ),
	        'borders' => array(
	            'left'     => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN ,
	                'color' => array(
	                    'rgb' => 'FFFFFF'
	                )
	            )             
	        )
	    ));

	    $objPHPExcel->getActiveSheet()->getStyle('D1:E1')->applyFromArray($estiloTituloReporte);
	    $objPHPExcel->getActiveSheet()->getStyle('D2:E2')->applyFromArray($estiloTituloColumnas);       
	    $objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "D3:E".($i-1));
	            
	    for($i = 'D'; $i <= 'F'; $i++){
	        $objPHPExcel->setActiveSheetIndex(0)            
	            ->getColumnDimension($i)->setAutoSize(TRUE);
	    }
	    
	    // Se asigna el nombre a la hoja
	    $objPHPExcel->getActiveSheet()->setTitle('Productos');

	    // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
	    $objPHPExcel->setActiveSheetIndex(0);
	    // Inmovilizar paneles 
	    //$objPHPExcel->getActiveSheet(0)->freezePane('A4');
	    $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,10);

	    // Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
	    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    header('Content-Disposition: attachment;filename="productos.xls"');
	    header('Cache-Control: max-age=0');

	    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	    $objWriter->save('php://output');
	    exit;
?>