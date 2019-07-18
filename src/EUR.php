<?php

namespace AleoStudio\CurrencyFormatter;


class EUR implements CurrencyInterface
{
    public function getPrefix()
    {
        return '€';
    }

    public function getSuffix()
    {
        return 'Eur';
    }
    
    public function getThousandsSep()
    {
        return '.';
    }

    public function getDecimalsSep()
    {
        return ',';
    }

    public function getDecimals()
    {
        return 2;
    }
}