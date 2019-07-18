<?php

namespace AleoStudio\CurrencyFormatter;


interface CurrencyInterface
{
    public function getPrefix();
    public function getSuffix();
    public function getThousandsSep();
    public function getDecimalsSep();
    public function getDecimals();
}