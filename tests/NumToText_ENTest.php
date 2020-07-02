<?php

namespace ivanovsaleksejs\NumToText;

use \PHPUnit\Framework\TestCase;
use ivanovsaleksejs\NumToText\NumToText_EN;

final class TIClientTest extends TestCase
{
    public function testNum(): void
    {
        $instance = new NumToText_EN();
        $currencies = include __DIR__ . '/../currencies.php';
        $instance->setCurrency($currencies['EN']['USD']);

        $this->assertEqualsIgnoringCase(
            'one hundred twenty three thousand four hundred fifty six',
            $instance->toWords(123456)
        );
        $this->assertEqualsIgnoringCase(
            'one hundred twenty three thousand four hundred fifty six dollars 78 cents',
            $instance->displayPrice(123456.78, true)
        );
        $this->assertEqualsIgnoringCase(
            'one hundred twenty three thousand four hundred fifty six dollars seventy eight cents',
            $instance->displayPrice(123456.78)
        );
        $this->assertEqualsIgnoringCase(
            'one hundred twenty three thousand four hundred fourteen dollars seventy eight cents',
            $instance->displayPrice(123414.78)
        );
    }

    public function testPrice(): void
    {
        $price = Price::toText(120.5, [['dollars', 'dollar'], ['cents', 'cent']], 'EN');
        $this->assertEqualsIgnoringCase(
            'one hundred twenty dollars fifty cents',
            $price
        );
    }

    public function testGenderHasNoMattter(): void
    {
        $price = Price::toText(123456.78, [['dollars', 'dollar'], ['cents', 'cent']], 'EN', false, false, [0, 0]);
        $this->assertEqualsIgnoringCase(
            'one hundred twenty three thousand four hundred fifty six dollars seventy eight cents',
            $price
        );

        $price = Price::toText(123456.78, [['dollars', 'dollar'], ['cents', 'cent']], 'EN', false, false, [0, 1]);
        $this->assertEqualsIgnoringCase(
            'one hundred twenty three thousand four hundred fifty six dollars seventy eight cents',
            $price
        );

        $price = Price::toText(123456.78, [['dollars', 'dollar'], ['cents', 'cent']], 'EN', false, false, [1, 0]);
        $this->assertEqualsIgnoringCase(
            'one hundred twenty three thousand four hundred fifty six dollars seventy eight cents',
            $price
        );

        $price = Price::toText(123456.78, [['dollars', 'dollar'], ['cents', 'cent']], 'EN', false, false, [1, 1]);
        $this->assertEqualsIgnoringCase(
            'one hundred twenty three thousand four hundred fifty six dollars seventy eight cents',
            $price
        );

        $price = Price::toText(123456.78, [['dollars', 'dollar'], ['cents', 'cent']], 'EN', false, false, [1, 2]);
        $this->assertEqualsIgnoringCase(
            'one hundred twenty three thousand four hundred fifty six dollars seventy eight cents',
            $price
        );

        $price = Price::toText(123456.78, [['dollars', 'dollar'], ['cents', 'cent']], 'EN', false, false, [2, 1]);
        $this->assertEqualsIgnoringCase(
            'one hundred twenty three thousand four hundred fifty six dollars seventy eight cents',
            $price
        );

        $price = Price::toText(123456.78, [['dollars', 'dollar'], ['cents', 'cent']], 'EN', false, false, [2, 2]);
        $this->assertEqualsIgnoringCase(
            'one hundred twenty three thousand four hundred fifty six dollars seventy eight cents',
            $price
        );

        $price = Price::toText(123456.78, [['dollars', 'dollar'], ['cents', 'cent']], 'EN', false, false, [2, 0]);
        $this->assertEqualsIgnoringCase(
            'one hundred twenty three thousand four hundred fifty six dollars seventy eight cents',
            $price
        );

        $price = Price::toText(123456.78, [['dollars', 'dollar'], ['cents', 'cent']], 'EN', false, false, [0, 2]);
        $this->assertEqualsIgnoringCase(
            'one hundred twenty three thousand four hundred fifty six dollars seventy eight cents',
            $price
        );
    }
}