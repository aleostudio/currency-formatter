<?php

namespace AleoStudio\CurrencyFormatter;

use AleoStudio\CurrencyFormatter\DefaultCurrency;


class CurrencyFactory
{
    public static function build($currency)
    {
        $currencyClass = '\AleoStudio\CurrencyFormatter\\'.strtoupper($currency);

        return (class_exists($currencyClass)) ? new $currencyClass() : new DefaultCurrency();
    }
}