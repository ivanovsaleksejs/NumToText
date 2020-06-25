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
            'восемьсот сорок один миллион двести восемьдесят четыре тысячи пятьсот сорок восемь',
            $instance->toWords(841284548)
        );
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

    public function testGender(): void
    {
        $price = Price::toText(1.01, [['рублей', 'рубль', 'рубля'], ['копеек', 'копейка', 'копейки']], 'RU', false, false, [0, 1]);
        $this->assertEqualsIgnoringCase(
            'один рубль одна копейка',
            $price
        );

        $price = Price::toText(1.02, [['рублей', 'рубль', 'рубля'], ['копеек', 'копейка', 'копейки']], 'RU', false, false, [0, 1]);
        $this->assertEqualsIgnoringCase(
            'один рубль две копейки',
            $price
        );

        $price = Price::toText(1.01, [['песо', 'песо', 'песо'], ['центаво', 'центаво', 'центаво']], 'RU', false, false, [2, 2]);
        $this->assertEqualsIgnoringCase(
            'одно песо одно центаво',
            $price
        );

        $price = Price::toText(1.02, [['песо', 'песо', 'песо'], ['центаво', 'центаво', 'центаво']], 'RU', false, false, [2, 2]);
        $this->assertEqualsIgnoringCase(
            'одно песо два центаво',
            $price
        );
    }
}
