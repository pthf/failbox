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
							 ->setTitle("Listado de Categorías y Subcategorías de los Productos")
							 ->setSubject("Carga Masiva")
							 ->setDescription("Tablas necesarias para los productos")
							 ->setKeywords("reporte categorías y subcategorías")
							 ->setCategory("Reporte excel");

		$tituloReporte = "Categorías y Subcategorías Failbox";
		$titulosColumnas = array('IDCATEGORIA', 'CATEGORIA', 'IDSUBCATEGORIA', 'SUBCATEGORIA');

       	$objPHPExcel->setActiveSheetIndex(0)
        		    ->mergeCells('D1:G1');

		// Se agregan los titulos del reporte
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('D1',$tituloReporte)
        		    ->setCellValue('D2',  $titulosColumnas[0])
		            ->setCellValue('E2',  $titulosColumnas[1])
		            ->setCellValue('F2',  $titulosColumnas[2])
		            ->setCellValue('G2',  $titulosColumnas[3]);

		//Se agregan los datos de las Subcategorias
		$query = "SELECT c.IdCategoria,c.Categoria,s.IdSubcategoria,s.Subcategoria FROM Subcategoria s
					INNER JOIN Categorias c ON c.IdCategoria = s.Categorias_IdCategoria";
	    $resultado = mysql_query($query,Conectar::con()) or die(mysql_error());
	    // $row = mysqli_num_rows($resultado);

		$i = 4;
		while ($fila = mysql_fetch_array($resultado)) {
			$objPHPExcel->setActiveSheetIndex(0)
        		    ->setCellValue('D'.$i, $fila['IdCategoria'])
            		->setCellValue('E'.$i, $fila['Categoria'])
            		->setCellValue('F'.$i, $fila['IdSubcategoria'])
            		->setCellValue('G'.$i, $fila['Subcategoria']);
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
				'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'	=> array('argb' => 'FF220835')
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
            'fill' 	=> array(
				'type'		=> PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
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
           	'fill' 	=> array(
				'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'		=> array('rgb' => 'FFFFFF')
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

		$objPHPExcel->getActiveSheet()->getStyle('D1:G1')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('D2:G2')->applyFromArray($estiloTituloColumnas);		
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "D3:G".($i-1));
				
		for($i = 'D'; $i <= 'G'; $i++){
			$objPHPExcel->setActiveSheetIndex(0)			
				->getColumnDimension($i)->setAutoSize(TRUE);
		}
		
		// Se asigna el nombre a la hoja
		$objPHPExcel->getActiveSheet()->setTitle('Categorias y Subcategorias');

		// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
		$objPHPExcel->setActiveSheetIndex(0);
		// Inmovilizar paneles 
		//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
		$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,10);

		// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="categorias_subcategorias.xls"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;

?>