<?php

namespace ivanovsaleksejs\NumToText;

/**
 *
 * Class NumToText
 * Converts integer numbers to text representation in English, Latvian or Russian.
 * @author Aleksejs Ivanovs <ivanovs.aleksejs@gmail.com>
 * @version 1.0
 *
 */
abstract class NumToText
{

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
    public function threeDigitsToWord($int)
    {

        $div100 = $int / 100;
        $mod100 = $int % 100;

        $returnString = $this->digitToWord(floor($div100), 2) .

            ($mod100 > 9 && $mod100 < 20
                // 10, 11, .. 19
                ? $this->teens[$mod100 - 10]
                //any other number
                : $this->digitToWord(floor($mod100 / 10), 1) . $this->digitToWord($int % 10));

        return trim($returnString);
    }

    /**
     * Returns currency string
     *
     * @param integer $int
     * @param boolean $cent
     *
     * @return string
     */
    public function getCurrencyString($int, $cent = false)
    {
        return  $this->currency[(int) ($cent > 0)][(int) ($int % 100 == 1)];
    }

    /**
     * Sets currency
     * See currencies.php example file
     *
     * @param mixed $currency
     */
    public function setCurrency(&$currency)
    {
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
    public function displayPrice($int, $cents_as_number = false, $display_zero_cents = false)
    {


        $part_int = (int) abs($int);
        $part_decimal = (int) round(abs($int) * 100 - floor(abs($int)) * 100);

        return ($int < 0 ? $this->negative . ' ' : '')
            . trim($this->toWords($part_int))
            . " " . $this->getCurrencyString($part_int) .
            (($int == floor($int) and !$display_zero_cents)
                ? ''
                :
                " " . ($cents_as_number ? $part_decimal : trim($this->toWords($part_decimal))) .
                " " . $this->getCurrencyString($part_decimal, true));
    }

    /**
     * Converts single digit to text
     * $suf is the parameter that shows if digit is tens, hundreds etc
     *
     * @param integer $digit
     * @param integer $suf
     *
     * @return string
     */
    abstract public function digitToWord($digit, $suf = 0);

    /**
     * Main method
     *
     * @param integer $int
     *
     * @return string
     */
    abstract public function toWords($int);
}
