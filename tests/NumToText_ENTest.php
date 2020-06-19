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
}