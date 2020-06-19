<?php

namespace ivanovsaleksejs\NumToText;

use \PHPUnit\Framework\TestCase;
use ivanovsaleksejs\NumToText\NumToText_RU;

final class NumToText_RUTest extends TestCase
{
    public function testNum(): void
    {
        $instance = new NumToText_RU();
        $currencies = include __DIR__ . '/../currencies.php';
        $instance->setCurrency($currencies['RU']['USD']);

        $this->assertEqualsIgnoringCase(
            'четырнадцать долларов четыре цента',
            $instance->displayPrice(14.04)
        );
    }

    public function testPrice(): void
    {
        $price = Price::toText(120.5, [['рублей', 'рубль', 'рубля'], ['копеек', 'копейка', 'копейки']], 'RU');
        $this->assertEqualsIgnoringCase(
            'сто двадцать рублей пятьдесят копеек',
            $price
        );
    }
}