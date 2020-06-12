<?php

namespace ivanovsaleksejs\NumToText;

use ivanovsaleksejs\NumToText\NumToText;

class NumToText_LV extends NumToText
{

    public $lang       = 'LV';
    public $negative   = 'mīnus';
    public $zero       = 'nulle';

    public $digits     = array('', 'viens', 'divi', 'trīs', 'četri', 'pieci', 'seši', 'septiņi', 'astoņi', 'deviņi');
    public $suffix     = array('', 'desmit ', 'simt ', 'padsmit ',);
    public $exp        = array('', ' tūkstoši ', ' miljoni ', ' miljardi ');
    public $exp1       = array('', ' tūkstotis ', ' miljons ', ' miljards ');

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
     * @param suffix $suf
     *
     * @return string
     */
    public function digitToWord($digit, $suf = 0)
    {

        return $digit > 0
            ? !($suf == 2  && $digit == 1)
            ? ($suf == 0  || $digit == 3
                ? $this->digits[$digit]
                : mb_substr($this->digits[$digit], 0, -1)) . $this->suffix[$suf]
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
    public function threeDigitsToWord($int)
    {

        $div100 = $int / 100;
        $mod100 = $int % 100;

        return $this->digitToWord(floor($div100), 2) .
            ($mod100 > 9 && $mod100 < 20
                // 10, 11, .. 19
                ? $mod100 == 10
                ? $this->suffix[1]
                : ($mod100 == 13
                    ? $this->digits[$mod100 % 10]
                    : mb_substr($this->digits[$mod100 % 10], 0, -1)) . $this->suffix[3]
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
    public function toWords($int)
    {

        $sign = $int < 0 ? $this->negative . ' ' : '';
        $int = abs($int);

        $this->step = 0;
        $return = $int == 0 ? $this->zero : '';

        while (($three = $int % 1000) || ($int >= 1)) {
            $int /= 1000;
            $return = ($three >= 1
                ? $this->threeDigitsToWord($three) .
                ($three % 10 == 1 && ($three % 100 < 11 || $three % 100 > 19)
                    ? $this->exp1[$this->step]
                    : $this->exp[$this->step])
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
    public function getCurrencyString($int, $cent = false)
    {
        $cent = $cent ? 1 : 0;
        return  $this->currency[(int) ($cent > 0)][(int) ($int % 100 != 11 && $int % 10 == 1)];
    }
}
