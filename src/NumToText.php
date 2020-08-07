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
     * @param int $int
     * @param int $gender
     *
     * @return string
     */
    public function threeDigitsToWord($int, $gender = 0)
    {

        $div100 = $int / 100;
        $mod100 = $int % 100;

        $returnString = $this->digitToWord(floor($div100), 2) .

            ($mod100 > 9 && $mod100 < 20
                // 10, 11, .. 19
                ? $this->teens[$mod100 - 10]
                //any other number
                : $this->digitToWord(floor($mod100 / 10), 1) . $this->digitToWord($int % 10, 0, $gender));

        return trim($returnString);
    }

    /**
     * Returns currency string
     *
     * @param int $int
     * @param bool $cent
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
     * @param  int  $int
     * @param  bool  $cents_as_number
     * @param  bool  $display_zero_cents
     * @param  array  $genders
     *
     * @return string
     */
    public function displayPrice($int, $cents_as_number = false, $display_zero_cents = false, $genders = [])
    {
        $part_int = (int) abs($int);
        $part_decimal = (int) round(abs($int) * 100 - floor(abs($int)) * 100);

        return ($int < 0 ? $this->negative . ' ' : '')
            . trim($this->toWords($part_int, $genders[0] ?? 0))
            . " " . $this->getCurrencyString($part_int) .
            (($int == floor($int) and !$display_zero_cents)
                ? ''
                :
                " " . ($cents_as_number ? $part_decimal : trim($this->toWords($part_decimal, $genders[1] ?? 0))) .
                " " . $this->getCurrencyString($part_decimal, true));
    }

    /**
     * Converts single digit to text
     * $suf is the parameter that shows if digit is tens, hundreds etc
     *
     * @param int $digit
     * @param int $suf
     * @param int $gender
     *
     * @return string
     */
    abstract public function digitToWord($digit, $suf = 0, $gender = 0);

    /**
     * Main method
     *
     * @param int $int
     * @param int $gender
     *
     * @return string
     */
    abstract public function toWords($int, $gender = 0);
}
