<?php

namespace ivanovsaleksejs\NumToText;

class Price
{
    /**
     * Shorthand function to display price as text
     *
     * @param integer $int
     * @param mixed $currencies
     * @param string $lang
     * @param boolean $cents_as_number
     * @param mixed $genders
     *
     * @return string
     * @example echo PriceToText(123456.78, array(array('dollars', 'dollar'), array('cents', 'cent')), 'EN', true);
     * Echoes 'one hundred twenty three thousand four hundred fifty six dollars 78 cents'
     * @example echo PriceToText(123456.78, array(array('dollars', 'dollar'), array('cents', 'cent')), 'EN');
     * Echoes 'one hundred twenty three thousand four hundred fifty six dollars seventy eight cents'
     */
    public static function toText($int, $currencies, $lang = 'LV', $cents_as_number = false, $display_zero_cents = false, $genders = 0)
    {

        $name = '\ivanovsaleksejs\NumToText\NumToText_' . $lang;

        class_exists($name) and call_user_func_array(array($name, '__i'), array())
            ->setCurrency($currencies);

        return
            class_exists($name)
            ? call_user_func_array(array($name, '__i'), array())
            ->displayPrice($int, $cents_as_number, $display_zero_cents, $genders)
            : false;
    }
}
