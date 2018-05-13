<?php
//
////echo '<div style="width: 3000px !important;">';
////
//ini_set('memory_limit', '1500M');
////
////$exelArr = [];
////$mod = ['column1','column2','column3'];
//////$i = 1;
////
////
//$fileName = __DIR__ . '/../../components/widgets/tco_widget/files/Rozbyty_222.xlsx';
////
//$data = \moonland\phpexcel\Excel::widget([
//			'mode' => 'import', 
//			'fileName' => $fileName,
//			'columns' => [
//				'TOVG'
//			]
//		]);
//
////echo '<pre>';
////\yii\helpers\VarDumper::dump($data);
////echo '</pre>';
////
////
////foreach ($data as $str) {
////	$part = explode('|', $str['TOVG Информация о товаре из Приложений']);
////	
////	if (sizeof($part) > 1) {
////		foreach ($part as $string) {
////			if(empty($string)) {
////				print(0);	echo '<br />';
////			} else {
////				print($str['G31_7 (Кол-во товара в доп.ед.)']);	echo '<br />';
////			}
////		}
////	} else {
////		if(empty($str['G31_7 (Кол-во товара в доп.ед.)'])) {
////				print(0);	echo '<br />';
////			} else {
////				print($str['G31_7 (Кол-во товара в доп.ед.)']);	echo '<br />';
////			}
////	}
////	
////	
////}
//wretewtewtewtwetewtwetwert
//
//
//foreach ($data as $str) {
//	
//	
//	$part = explode('|', $str['TOVG Информация о товаре из Приложений']);
//	
//	if (sizeof($part) > 1) {
//		
//		foreach ($part as $string) {
//			
////			if(empty($string)) {
////				print(0);	echo '<br />';
////			} else {
////
//			print($string);	echo '<br />';
////				print($string);	echo '<br />';	
////			}
//			
////			print($string);	echo '<br />';	
////			print($str['G082 Наименование получателя']);	echo '<br />';
//			
//			
////			$stringQ = $string.';';
////			preg_match('/ртикул: (.*?);/', $string, $match);
//			
////			preg_match('/во: (.*?) ШТ;/', $string, $match);
////			preg_match('/одель: (.*?);/', $stringQ, $match);
//			
////			if(empty($match)) {
////				
//////				preg_match('/ртикул: (.*?);/', $string, $matchQ);
//////				if(empty($matchQ)) {
////					print(0);	echo '<br />';
//////				} else {
//////					print($matchQ[1]);	echo '<br />';
//////				}	
////			} else {
////				print($match[1]);	echo '<br />';
////			}
//			
//		}
//		
//	} elseif(sizeof($part) == 1) {
////		print($str['OD']);	echo '<br />';
//		print($part[0]);	echo '<br />';
//		
////		$stringQ = $part[0].';';
//		
////		preg_match('/ртикул: (.*?);/', $part[0], $match);
//////		preg_match('/во: (.*?) ШТ;/', $part[0], $match);
//////		preg_match('/одель: (.*?);/', $stringQ, $match);
////		
////		if(empty($match)) {
////			
//////			preg_match('/ртикул: (.*?);/', $part[0], $matchQ);
//////				if(empty($matchQ)) {
////					print(0);	echo '<br />';
//////				} else {
//////					print($matchQ[1]);	echo '<br />';
//////				}
////	
////			} else {
////				print($match[1]);	echo '<br />';
////			}	
//				
//			
//		
//	} elseif(empty($part)) {
//
//			print(0);	echo '<br />';
//		
//		}
//		
//	}	
//////	
//////	
//////	
//////}
//////
////////echo '<pre>';
////////\yii\helpers\VarDumper::dump($exelArr);
////////echo '</pre>';
////////$part = explode('|', $str['TOVG']);
//////
//////
