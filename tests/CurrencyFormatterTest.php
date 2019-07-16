<?php
/*****************************************************************************
 *                                                                           * 
 *                    AleoStudio - PHPUnit installation                      *
 *                    =================================                      *
 *                    alessandro.orru@aleostudio.com                         *
 *                                                                           *
 * $ wget https://phar.phpunit.de/phpunit-6.5.phar                           *
 * $ chmod +x phpunit-6.5.phar                                               *
 * $ sudo mv phpunit-6.5.phar /usr/local/bin/phpunit                         *
 *                                                                           *
 * Launch with:                                                              *
 * $ phpunit --bootstrap vendor/autoload.php tests/CurrencyFormatterTest.php *
 *                                                                           *
 *****************************************************************************/

namespace AleoStudio\CurrencyFormatter;

use AleoStudio\CurrencyFormatter\CurrencyFormatter;
use PHPUnit\Framework\TestCase;

class CurrencyFormatterTest extends TestCase
{
    public function testConvertFloatToEUR()
    {
        $floatPrice = 1000.456;

        $this->assertEquals('€ 1.000,46',     CurrencyFormatter::EUR($floatPrice)->withPrefix('€')->format());
        $this->assertEquals('EURO 1.000,456', CurrencyFormatter::EUR($floatPrice)->withPrefix('EURO')->decimals(3)->format());
        $this->assertEquals('1.000,46 Eur',   CurrencyFormatter::EUR($floatPrice)->withSuffix('Eur')->format());
    }


    public function testConvertFloatToUSD()
    {
        $floatPrice = 1000.456;

        $this->assertEquals('$ 1,000.46',     CurrencyFormatter::USD($floatPrice)->withPrefix('$')->format());
        $this->assertEquals('USD 1,000.456',  CurrencyFormatter::USD($floatPrice)->withPrefix('USD')->decimals(3)->format());
        $this->assertEquals('1,000.46 USD',   CurrencyFormatter::USD($floatPrice)->withSuffix('USD')->format());
    }
}