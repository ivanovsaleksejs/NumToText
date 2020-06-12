<?php

namespace ivanovsaleksejs\NumToText;

class Num
{
    /**
     * Shorthand function for the class
     *
     * @param integer $int
     * @param string $lang
     *
     * @return string
     * @example echo Num::toText(123456, 'EN');
     * Echoes 'one hundred twenty three thousand four hundred fifty six'
     */
    public static function toText($int, $lang = 'LV'): string
    {
        $name = '\ivanovsaleksejs\NumToText\NumToText_' . $lang;

        return
            class_exists($name)
            ? call_user_func_array(array($name, '__i'), array())
            ->toWords((int) $int)
            : false;
    }
}
