<?php

namespace AleoStudio\CurrencyFormatter;

use AleoStudio\CurrencyFormatter\CurrencyFactory;
use AleoStudio\CurrencyFormatter\DefaultCurrency;


final class CurrencyFormatter
{
    private $value;
    private $suffix;
    private $prefix;
    private $decimals;
    private $thousandsSep;
    private $decimalsSep;
    private $currency;

    private static $instance;




    /**
     * Singleton instance. It is private because we
     * call it from the static EUR and USD methods.
     * 
     * @return static $instance
     */
    private static function getInstance()
    {
        if (null === static::$instance)
            static::$instance = new static();

        return static::$instance;
    }




    /**
     * It sets the given currency with an abstract factory.
     * 
     * @param  string $currency
     * @return static $instance with the given currency.
     */
    public static function set($currency)
    {
        $currency = CurrencyFactory::build($currency);

        // Reset the singleton instance everytime we use the set method.
        static::$instance = null;

        if ($currency instanceof DefaultCurrency)
            return self::getInstance()->setCurrency($currency);

        return self::getInstance()
            ->setCurrency($currency)
            ->decimals($currency->getDecimals())
            ->withSuffix($currency->getSuffix())
            ->withPrefix($currency->getPrefix())
            ->withDecimalsSeparator($currency->getDecimalsSep())
            ->withThousandsSeparator($currency->getThousandsSep());
    }




    /**
     * It set the given value and returns the singleton instance
     * to be used with other fluent methods.
     * 
     * @param  int/float $value
     * @return static    $instance with the given value.
     */
    public function value($value)
    {
        if (is_null($value))
            throw new \Exception("Currency value can not be null");

        self::isValid($value);
        $this->value = $value;

        return $this;
    }




    /**
     * It set the given thousands separator and returns the singleton instance
     * to be used with other fluent methods.
     * 
     * @param  string $separator
     * @return static $instance with the given separator.
     */
    public function withThousandsSeparator($separator)
    {
        if (is_null($separator))
            throw new \Exception("Thousands separator can not be null");

        $this->thousandsSep = trim($separator);

        return $this;
    }




    /**
     * It set the given decimals separator and returns the singleton instance
     * to be used with other fluent methods.
     * 
     * @param  string $separator
     * @return static $instance with the given separator.
     */
    public function withDecimalsSeparator($separator)
    {
        if (is_null($separator))
            throw new \Exception("Decimals separator can not be null");

        $this->decimalsSep = trim($separator);

        return $this;
    }




    /**
     * It set the given prefix and returns the singleton instance
     * to be used with other fluent methods.
     * 
     * @param  string $prefix
     * @return static $instance with the given prefix.
     */
    public function withPrefix($prefix)
    {
        if (is_null($prefix))
            throw new \Exception("Currency prefix can not be null");

        $this->prefix = trim($prefix);
        $this->suffix = '';

        return $this;
    }




    /**
     * It set the given suffix and returns the singleton instance
     * to be used with other fluent methods.
     * 
     * @param  string $suffix
     * @return static $instance with the given suffix.
     */
    public function withSuffix($suffix)
    {
        if (is_null($suffix))
            throw new \Exception("Currency suffix can not be null");

        $this->suffix = trim($suffix);
        $this->prefix = '';

        return $this;
    }




    /**
     * It set the given decimals number and returns the singleton instance
     * to be used with other fluent methods.
     * 
     * @param  int $decimals
     * @return static $instance with the given decimals.
     */
    public function decimals($decimals)
    {
        if (is_null($decimals))
            throw new \Exception("Currency decimals can not be null");

        $this->decimals = $decimals;

        return $this;
    }




    /**
     * It set the given currency and returns the singleton instance
     * to be used with other fluent methods.
     * 
     * @param  string $currency
     * @return static $instance with the given decimals.
     */
    private function setCurrency($currency)
    {
        if (is_null($currency))
            throw new \Exception("Currency can not be null");

        $this->currency = $currency;

        return $this;
    }




    /**
     * Last private fluent method of the flow. Depending by the currency set
     * it will format the price with the right comma and dot positions
     * adding the optional suffix and prefix if they were set.
     * 
     * @return string $formattedCurrency
     */
    private function format()
    {
        if (is_null($this->currency))     throw new \Exception("Currency can not be null");
        if (is_null($this->decimals))     throw new \Exception("Currency decimals can not be null");
        if (is_null($this->prefix))       throw new \Exception("Currency prefix can not be null");
        if (is_null($this->suffix))       throw new \Exception("Currency suffix can not be null");
        if (is_null($this->value))        throw new \Exception("Currency value can not be null");
        if (is_null($this->thousandsSep)) throw new \Exception("Thousands separator can not be null");
        if (is_null($this->decimalsSep))  throw new \Exception("Decimals separator can not be null");

        $prefix = $this->prefix ? $this->prefix.' ' : '';
        $suffix = $this->suffix ? ' '.$this->suffix : '';

        return $prefix.number_format($this->value, $this->decimals, $this->decimalsSep, $this->thousandsSep).$suffix;
    }




    /**
     * Static method to convert a currency string
     * to a valid integer/float value.
     * 
     * @param  string $currency
     * @return float  $value
     */
    public static function toFloat($currency)
    {
        $commaPos = strrpos($currency, ',');
        $dotPos   = strrpos($currency, '.');
        $sep      = (($dotPos > $commaPos) && $dotPos) ? $dotPos : ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);
  
        if (!$sep) return floatval(preg_replace("/[^0-9]/", '', $currency));

        return floatval(
            preg_replace("/[^0-9]/", "", substr($currency, 0, $sep)) . '.' .
            preg_replace("/[^0-9]/", "", substr($currency, $sep+1, strlen($currency)))
        );
    }




    /**
     * Simple validator. It checks if the given string
     * is a valid float/double value.
     * 
     * @param  int/float $value
     * @return exception $e if it is not valid.
     */
    private static function isValid($value)
    {
        if (!is_nan($value) && !is_double($value) && !is_float($value) && !is_int($value))
            throw new \Exception("Format exception");
    }




    /**
     * toString override to return the formatted currency
     */
    public function __toString()
    {
        try {
            return $this->format();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }




    /**
     * Clone and Wakeup override to keep the singleton.
     */
    private function __clone()  { }
    private function __wakeup() { }
}