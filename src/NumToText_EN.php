<?php

namespace ivanovsaleksejs\NumToText;

use ivanovsaleksejs\NumToText\NumToText;

class NumToText_EN extends NumToText
{

    public $lang = 'EN';
    public $negative = 'minus';
    public $zero = 'zero';

    public $digits     = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'one', 'one');
    public $tens       = array('', 'ten ', 'twenty ', 'thirty ', 'forty ', 'fifty ', 'sixty ', 'seventy ', 'eighty ', 'ninety ');
    public $teens      = array('ten ', 'eleven ', 'twelve ', 'thirteen ', 'fourteen ', 'fifteen ', 'sixteen ', ' seventeen ', 'eighteen ', 'nineteen ');
    public $exp        = array('', ' thousand ', ' million ', ' billion ');

    /**
     * @return instanceof self
     */
    public static function __i()
    {
        return (!self::$i instanceof self) ? (self::$i = new self()) : self::$i;
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
    public function digitToWord($digit, $suf = 0)
    {

        return $digit > 0
            ? $suf == 2
            ? $this->hundreds[$digit]
            : ($suf == 1
                ? $this->tens[$digit]
                : $this->digits[$digit])
            : '';
    }

    /**
     * Main method
     *
     * @param integer $int
     *
     * @return string
     */
    public function toWords($int)
    {

        if (!isset($this->hundreds)) {
            $this->hundreds = $this->digits;
            array_walk($this->hundreds, function (&$val, $key) {
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

        return $sign . $return;
    }
}
