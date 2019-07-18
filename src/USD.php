<?php

namespace AleoStudio\CurrencyFormatter;


class USD implements CurrencyInterface
{
    public function getPrefix()
    {
        return '$';
    }

    public function getSuffix()
    {
        return 'Dollars';
    }
    
    public function getThousandsSep()
    {
        return ',';
    }

    public function getDecimalsSep()
    {
        return '.';
    }

    public function getDecimals()
    {
        return 2;
    }
}