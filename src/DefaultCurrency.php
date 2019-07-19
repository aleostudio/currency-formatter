<?php

namespace AleoStudio\CurrencyFormatter;


class DefaultCurrency implements CurrencyInterface
{
    public function getPrefix()
    {
        return null;
    }

    public function getSuffix()
    {
        return null;
    }
    
    public function getThousandsSep()
    {
        return null;
    }

    public function getDecimalsSep()
    {
        return null;
    }

    public function getDecimals()
    {
        return null;
    }
}