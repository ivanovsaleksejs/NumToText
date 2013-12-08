<?

ini_set('display_errors', -1);
?>
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
    </head>
    <body>
        <table>
            <?php
            
            require_once('NumToText.php');
            require_once('currencies.php');
            
            $langs = array('LV', 'RU', 'EN');
            $lang_count = count($langs);            

            ?>
            <tr>
                <td>Language</td>
                <td>Number</td>
                <td>Number as text (integer part)</td>
                <td>Price as text</td>
            </tr>
            <tr>
                <td>Start time</td>
                <td><?php echo microtime(true)?></td>
            </tr>
            <?php
            for ($i=0; $i<1000; $i++){
                
                //Choose language
                $index = $i%$lang_count;

                //Choose currency randomly
                $curr_indexes = array_keys($currencies[$langs[$index]]);
                $curr_index = $curr_indexes[mt_rand(0, count($currencies[$langs[$index]])-1)];
                $curr = $currencies[$langs[$index]][$curr_index];
                
                //Number from 0 to 1000
                $n = mt_rand(0, 1000) + mt_rand(0, 100)/100;
                echo "<tr><td>$i ".$langs[$index]."</td><td>$n</td><td>" 
                    . NumToText($n, $langs[$index]) . "</td><td>"
                    . PriceToText($n, $curr, $langs[$index]) . "</td></tr>";
                
                //Number from 1000 to 1000000
                $n = mt_rand(1000, 1000000) + mt_rand(0, 100)/100;
                echo "<tr><td>$i ".$langs[$index]."</td><td>$n</td><td>" 
                    . NumToText($n, $langs[$index]) . "</td><td>"
                    . PriceToText($n, $curr, $langs[$index], true) . "</td></tr>";

                //Number from 1000000 to 1000000000    
                $n = mt_rand(1000000, 1000000000) + mt_rand(0, 100)/100;
                echo "<tr><td>$i ".$langs[$index]."</td><td>$n</td><td>" 
                    . NumToText($n, $langs[$index]) . "</td><td>"
                    . PriceToText($n, $curr, $langs[$index]) . "</td></tr>";

                //Additional test for billions
                $n = mt_rand(2000100000, 2010000000) + mt_rand(0, 100)/100;
                echo "<tr><td>$i ".$langs[$index]."</td><td>$n</td><td>" 
                    . NumToText($n, $langs[$index]) . "</td><td>"
                    . PriceToText($n, $curr, $langs[$index], true) . "</td></tr>";
                    
				// Negative
                $n = -mt_rand(0, 1000) + mt_rand(0, 100)/100;
                echo "<tr><td>$i ".$langs[$index]."</td><td>$n</td><td>" 
                    . NumToText($n, $langs[$index]) . "</td><td>"
                    . PriceToText($n, $curr, $langs[$index]) . "</td></tr>";
            }
            ?>
            <?php
				$samples = array(
					0,
					1.0,
					1.1,
					13.37,
				);
				
				foreach ($samples as $s){
					for ($can = 0; $can < 2; $can++){
						for ($dzc = 0; $dzc < 2; $dzc++){
							echo '<tr><td>', ($can ? '' : '!'), 'cents_as_number; ',
								($dzc ? '' : '!'), 'display_zero_cents</td><td>',
								$s, '</td><td>', PriceToText($s, $currencies['LV']['EUR'], 'LV', $can, $dzc), '</td></tr>';
						}
					}
				}
			?>
            <tr>
                <td>End time</td>
                <td><?php echo microtime(true)?></td>
            </tr>
        </table>
    </body>
</html>
