<?php

/**
 * 
 * Class NumToText
 * Converts integer numbers to text representation in English, Latvian or Russian.
 * @author Aleksejs Ivanovs <ivanovs.aleksejs@gmail.com>
 * @version 1.0
 * 
 */
class NumToText {

    public static $i;

    public
        $lang       = false,
        $step       = 0,
        $currency   = array();
    /**
     * Converts 3-digit portions (like thousands, millions etc) of number to a text
     *
     * @param integer $int
     *
     * @return string
     */
    public function threeDigitsToWord($int){

        $div100 = $int / 100;
        $mod100 = $int % 100;

        return 
            $this->digitToWord(floor($div100), 2) .

            ($mod100 > 9 && $mod100 < 20
                // 10, 11, .. 19
                ? $this->teens[$mod100 - 10]
                //any other number
                : $this->digitToWord(floor($mod100 / 10), 1) . $this->digitToWord($int % 10));
    }

    /**
     * Returns currency string
     *
     * @param integer $int
     * @param boolean $cent
     *
     * @return string
     */
    public function getCurrencyString($int, $cent = false) {
        return  $this->currency[(int)($cent > 0)][(int)($int % 100 == 1)];
    }

    /**
     * Sets currency
     * See currencies.php example file
     *
     * @param mixed $currency
     */
    public function setCurrency(&$currency) {
        $this->currency = $currency;
    }

    /**
     * Returns price as text
     *
     * @param integer $int
     * @param boolean $cents_as_number
     *
     * @return string
     */
    public function displayPrice($int, $cents_as_number = false, $display_zero_cents = false) {


        $part_int = (int)abs($int);
        $part_decimal = (int)round(abs($int) * 100 - floor(abs($int)) * 100);

        return ($int < 0 ? $this->negative . ' ' : '')
            . $this->toWords($part_int)
            . " " . $this->getCurrencyString($part_int) .
            (($int == floor($int) and !$display_zero_cents)
                ? ''
                :
                    " " . ($cents_as_number ? $part_decimal : $this->toWords($part_decimal)) .
                    " " . $this->getCurrencyString($part_decimal, true)
            );
    }



}

class NumToText_LV extends NumToText{

    public
        $lang       = 'LV',
        $negative   = 'mīnus',
        $zero       = 'nulle';

    /**
     * @return instanceof self
     */
    public static function __i(){
        return (!self::$i instanceof self) ? (self::$i = new self) : self::$i;
    }

    public
        $digits     = array('', 'viens', 'divi', 'trīs', 'četri', 'pieci', 'seši', 'septiņi', 'astoņi', 'deviņi'),
        $suffix     = array('', 'desmit ', 'simt ', 'padsmit ', ),
        $exp        = array('', ' tūkstoši ', ' miljoni ', ' miljardi '),
        $exp1       = array('', ' tūkstotis ', ' miljons ', ' miljards ');

    /**
     * Converts single digit to text
     * $suf is the parameter that shows if digit is tens, hundreds etc
     *
     * @param integer $digit
     * @param suffix $suf
     * 
     * @return string
     */
    public function digitToWord($digit, $suf = 0){

        return $digit > 0
            ? !($suf == 2  && $digit == 1)
                ? ($suf == 0  || $digit == 3
                    ? $this->digits[$digit]
                    : mb_substr($this->digits[$digit], 0, -1)
                ) . $this->suffix[$suf]
                : $this->suffix[2]
            : '';

    }

    /**
     * Converts 3-digit portions (like thousands, millions etc) of number to a text
     *
     * @param integer $int
     * 
     * @return string
     */
    public function threeDigitsToWord($int){

        $div100 = $int / 100;
        $mod100 = $int % 100;

        return $this->digitToWord(floor($div100), 2) .
            ($mod100 > 9 && $mod100 < 20
                // 10, 11, .. 19
                ? $mod100 == 10
                    ? $this->suffix[1]
                    : ($mod100 == 13
                        ? $this->digits[$mod100 % 10]
                        : mb_substr($this->digits[$mod100 % 10], 0, -1)
                ) . $this->suffix[3]
                //any other number
                : $this->digitToWord(floor($mod100 / 10), 1) . $this->digitToWord($int % 10));

    }

    /**
     * Main method
     *
     * @param integer $int
     * 
     * @return string
     */
    public function toWords($int){

        $sign = $int < 0 ? $this->negative . ' ' : '';
        $int = abs($int);

        $this->step = 0;
        $return = $int == 0 ? $this->zero : '';

        while (($three = $int%1000) || ($int >= 1)) {
            $int /= 1000;
            $return = ($three >= 1
                ? $this->threeDigitsToWord($three) .
                    ($three % 10 == 1 && ($three % 100 < 11 || $three % 100 > 19)
                        ? $this->exp1[$this->step]
                        : $this->exp[$this->step]
                    )
                : '') . $return;
            $this->step++;
        }

        return $sign . $return;

    }

    /**
     * Returns currency string
     *
     * @param integer $int
     * @param boolean $cent
     * 
     * @return string
     */
    public function getCurrencyString($int, $cent = false) {
        $cent = $cent ? 1 : 0;
        return  $this->currency[(int)($cent > 0)][(int)($int % 100 != 11 && $int % 10 == 1)];
    }


}

class NumToText_RU extends NumToText{

    public
        $lang       = 'RU',
        $negative   = 'минус',
        $zero       = 'ноль';

    /**
    * @return instanceof self
    */
    public static function __i(){
        return (!self::$i instanceof self) ? (self::$i = new self) : self::$i;
    }

    public
        $digits     = array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять', 'одна', 'две'),
        $tens       = array('', 'десять ', 'двадцать ', 'тридцать ', 'сорок ', 'пятьдесят ', 'шестьдесят ', 'семьдесят ', 'восемьдесят ', 'девяносто '),
        $teens      = array('десять ', 'одиннадцать ', 'двенадцать ', 'тринадцать ', 'четырнадцать ', 'пятнадцать ', 'шестнадцать ', ' семнадцать ', 'восемнадцать ', 'девятнадцать '),
        $hundreds   = array('', ' сто ', ' двести ', ' триста ', ' четыреста ', ' пятьсот ', ' шестьсот ', ' семьсот ', ' восемьсот ', ' девятьсот '),
        $exp        = array('', ' тысяч ', ' миллионов ', ' миллиардов '),
        $exp1       = array('', ' тысяча ', ' миллион ', ' миллиард '),
        $exp2       = array('', ' тысячи ', ' миллиона ', ' миллиарда ');

    /**
     * Converts single digit to text
     * $suf is the parameter that shows if digit is tens, hundreds etc
     *
     * @param integer $digit
     * @param suffix $suf
     * 
     * @return string
     */
    public function digitToWord($digit, $suf = 0){

        return $digit > 0
            ? $suf == 2
                ? $this->hundreds[$digit]
                : ($suf == 1
                    ? $this->tens[$digit]
                    : (($digit == 1 || $digit == 2) && $this->step == 1
                        ? $this->digits[$digit+9]
                        : $this->digits[$digit])
                )
            : '';

    }

    /**
     * Main method
     *
     * @param integer $int
     * 
     * @return string
     */
    public function toWords($int){

        $sign = $int < 0 ? $this->negative . ' ' : '';
        $int = abs($int);

        $this->step = 0;
        $return = $int == 0 ? $this->zero : '';

        while (($three = $int % 1000) || ($int >= 1)) {
            $int /= 1000;

            $mod10 = $three % 10;
            $mod100 = $three % 100;

            $exp = $mod10 > 1 && $mod10 < 5 && ($mod100 < 11 || $mod100 > 19) ? $this->exp2[$this->step] : $this->exp[$this->step];
            $exp = $mod10 == 1 && ($mod100 < 11 || $mod100 > 19) ? $this->exp1[$this->step] : $exp;

            $return = ($three >= 1
                ? $this->threeDigitsToWord($three) . $exp
                : '')
                . $return;
            $this->step++;
        }

        return $sign.$return;

    }

    /**
     * Returns currency string
     *
     * @param integer $int
     * @param boolean $cent
     * 
     * @return string
     */
    public function getCurrencyString($int, $cent = false) {
        $cent = $cent ? 1 : 0;
        return (($int % 100 > 9 && $int % 100 < 20) || $int % 10 == 0 || $int % 10 > 4)
                    ? $this->currency[$cent][0]
                    : ($int % 10 == 1 ? $this->currency[$cent][1] : $this->currency[$cent][2] );
    }

}

class NumToText_EN extends NumToText{

    public
        $lang = 'EN',
        $negative = 'minus',
        $zero = 'zero';

    /**
     * @return instanceof self
     */
    public static function __i(){
        return (!self::$i instanceof self) ? (self::$i = new self) : self::$i;
    }

    public
        $digits     = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'one', 'one'),
        $tens       = array('', 'ten ', 'twenty ', 'thirty ', 'forty ', 'fifty ', 'sixty ', 'seventy ', 'eighty ', 'ninety '),
        $teens      = array('ten ', 'eleven ', 'twelve ', 'thirteen ', 'fourteen ', 'fifteen ', 'sixteen ', ' seventeen ', 'eighteen ', 'nineteen '),
        $exp        = array('', ' thousand ', ' million ', ' billion ');

    /**
     * Converts single digit to text
     * $suf is the parameter that shows if digit is tens, hundreds etc
     *
     * @param integer $digit
     * @param integer $suf
     * 
     * @return string
     */
    public function digitToWord($digit, $suf = 0){

        return $digit > 0
        ? $suf == 2
            ? $this->hundreds[$digit]
            : ($suf == 1
                ? $this->tens[$digit]
                : $this->digits[$digit]
            )
        : '';

    }

    /**
     * Main method
     *
     * @param integer $int
     * 
     * @return string
     */
    public function toWords($int){

        if (!isset($this->hundreds)) {
            $this->hundreds = $this->digits;
            array_walk($this->hundreds, function(&$val, $key) {
                $val .= ' hundred ';
            });
        }

        $sign = $int < 0 ? $this->negative . ' ' : '';
        $int = abs($int);

        $this->step = 0;
        $return = $int == 0 ? $this->zero : '';

        while (($three = $int % 1000) || ($int >= 1)) {
            $int /= 1000;
            $return = ($three >= 1
                ? $this->threeDigitsToWord($three) . $this->exp[$this->step]
                : '') . $return;
            $this->step++;
        }

        return $sign.$return;

    }

}

/**
 * Shorthand function for the class
 *
 * @param integer $int
 * @param string $lang
 *
 * @return string
 * @example echo NumToText(123456, 'EN');
 * Echoes 'one hundred twenty three thousand four hundred fifty six'
 */
function NumToText($int, $lang = 'LV'){

    $name = 'NumToText_' . $lang;

    return 
        class_exists($name)
        ? call_user_func_array(array($name, '__i'), array())
            ->toWords((int)$int)
        : false;

}

/**
 * Shorthand function to display price as text
 *
 * @param integer $int
 * @param mixed $currencies
 * @param string $lang
 * @param boolean $cents_as_number
 *
 * @return string
 * @example echo PriceToText(123456.78, array(array('dollars', 'dollar'), array('cents', 'cent')), 'EN', true);
 * Echoes 'one hundred twenty three thousand four hundred fifty six dollars 78 cents'
 * @example echo PriceToText(123456.78, array(array('dollars', 'dollar'), array('cents', 'cent')), 'EN');
 * Echoes 'one hundred twenty three thousand four hundred fifty six dollars seventy eight cents'
 */
function PriceToText($int, $currencies, $lang = 'LV', $cents_as_number = false, $display_zero_cents = false) {

    $name = 'NumToText_' . $lang;

    class_exists($name) AND call_user_func_array(array($name, '__i'), array())
                                ->setCurrency($currencies);

    return 
        class_exists($name)
        ? call_user_func_array(array($name, '__i'), array())
            ->displayPrice($int, $cents_as_number, $display_zero_cents)
        : false;
}
