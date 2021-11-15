<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);


// файл з вхідними данними
require_once 'data/workers_array.php';




/**
* Функція порівняння прізвищ працівників.
* Працьє з українською абеткою.
* Враховує деякі підводні камені кодування 
* української мови. 
* Приймає два массива які містять елементи з
* ключами fullname (ПІБ співробітника). 
* Наприклад $a['fullname'].
* Функція порівнює два призвіща і повертає:
* 
* 0 - однакові;
* 1 - перше більше другого;
* -1 - перше менше другого.
* 
* 
*
* @param array $a
* @param array $b
*    
* @return int  
*/

function cmp_uk($a, $b)
{
	 /* 
	    кодові винятки (афавітні аномалії)
	    які трапляються при роботі з українським алфавітом 
	 */
     $char_exceptions = 'єіїґ';

	 /* 
	    массив в якому ключами є букви українського алфавіту
	    а значеннями їх номерні позиції в алфавіті
     */
	 $ukCharsCode = [
        'а' => 1, 'б' => 2, 'в' => 3,
		'г' => 4, 'ґ' => 5, 'д' => 6,
		'е' => 7, 'є' => 8, 'ж' => 9,
		'з' => 10, 'и' => 11, 'і' => 12,
		'ї' => 13, 'й' => 14, 'к' => 15,
        'л' => 16, 'м' => 17, 'н' => 18,
		'о' => 19, 'п' => 20, 'р' => 21,
		'с' => 22, 'т' => 23, 'у' => 24,
		'ф' => 25, 'х' => 26, 'ц' => 27,
		'ч' => 28, 'ш' => 29, 'щ' => 30,
		'ь' => 31, 'ю' => 32, 'я' => 33,
     ];
     
     // вибірка першого призвіща 
     $firstName = mb_strtolower($a['fullname'], 'utf-8');
	 $surname_1 = explode(' ', $firstName);
	 $surname_1 = $surname_1[0];

	 // вибірка наступного призвіща 
     $secondName = mb_strtolower($b['fullname'], 'utf-8'); 
	 $surname_2 = explode(' ', $secondName);
	 $surname_2 = $surname_2[0];
	 
	 // довжина прізвищ
     $len_1 = mb_strlen($surname_1);
     $len_2 = mb_strlen($surname_2);
      
	 /*
	    максимальна довжина рядка для порівняння
	    дорівнює довжині коротшого прізвища
	 */	
     $maxLen_cmp = ($len_1 > $len_2) ? $len_2 : $len_1;

	 // прапорець результатів порівняння
     $cmp_flag = 0;

     $i = 0;

     while($i < $maxLen_cmp )
     {
		// вибірка одного символу з кожного прізвища
        $ch_1 = mb_substr($surname_1, $i, 1);
        $ch_2 = mb_substr($surname_2, $i, 1);
		
		/* 
		   порівняння символів
		   базується на порівнянні їх позицій в алфавіті
		*/
		if($ukCharsCode[$ch_1] !== $ukCharsCode[$ch_2])
		{
			if($ukCharsCode[$ch_1] > $ukCharsCode[$ch_2])
			{
				$cmp_flag = 1;
			}
			else{
				$cmp_flag = -1;
			}
			
			break;
		}
		
       
        $i++;  
     }
	 
	 // прізвища рівні (однакові)
     if($cmp_flag == 0)
     {
         return 0;
     }
	 
     // одне з прізвищ більше
     return ($cmp_flag < 0) ? -1 : 1;
}


setlocale(LC_ALL, 'ua_UA.UTF-8');

// сортуємо массив власною функцією
if(usort($arr, 'cmp_uk'))
{
	// сторінка показу массиву
    include_once 'views/table.php';
}



