<?php

namespace AleoStudio\CurrencyFormatter;


final class CurrencyFormatter
{
    /**
     * Private properties.
     */
    private $value;
    private $suffix;
    private $prefix;
    private $currency;
    private $decimals = 2;


    /**
     * Private Singleton instance.
     */
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
     * Simple validator. It checks if the given string
     * is a valid float/double value.
     * 
     * @param  int/float $value
     * @return exception $e if it is not valid.
     */
    private function isValid($value)
    {
        if (!is_nan($value) && !is_double($value) && !is_float($value) && !is_int($value))
            throw new \Exception("Format exception");
    }


    /**
     * It returns the unique EurFormatter instance assigning to it
     * the EUR currency and the given float value (if valid).
     * 
     * @param  int/float $value
     * @return static    $instance with the given currency and value.
     */
    public static function EUR($value)
    {
        self::isValid($value);
        static::$instance = null;

        return self::getInstance()->setCurrency('EUR')->setValue($value);
    }


    /**
     * It returns the unique EurFormatter instance assigning to it
     * the USD currency and the given float value (if valid).
     * 
     * @param  int/float $value
     * @return static    $instance with the given currency and value.
     */
    public static function USD($value)
    {
        self::isValid($value);
        static::$instance = null;

        return self::getInstance()->setCurrency('USD')->setValue($value);
    }


    /**
     * It set the given value and returns the singleton instance
     * to be used with other fluent methods.
     * 
     * @param  int/float $value
     * @return static    $instance with the given value.
     */
    private function setValue($value)
    {
        $this->value = $value;
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
        $this->suffix = trim($suffix);
        $this->prefix = null;
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
        $this->prefix = trim($prefix);
        $this->suffix = null;
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
        $this->decimals = $decimals;
        return $this;
    }


    /**
     * It set the given currency and returns the singleton instance
     * to be used with other fluent methods.
     * 
     * @param  string $currency
     * @return static $instance with the given currency.
     */
    private function setCurrency($currency)
    {
        // TODO: check if the given currency is accepted.
        $this->currency = trim(strtoupper($currency));
        return $this;
    }


    /**
     * Last fluent method of the flow. Depending by the currency set
     * it will format the price with the right comma and dot positions
     * adding the optional suffix and prefix if they were set.
     * 
     * @return string $formattedCurrency
     */
    public function format()
    {
        switch($this->currency)
        {
            case 'EUR':
                return (($this->prefix) ? $this->prefix . ' ' : '') . number_format($this->value, $this->decimals, ',', '.') . (($this->suffix) ? ' ' . $this->suffix : '');
                break;

            case 'USD':
                return (($this->prefix) ? $this->prefix . ' ' : '') . number_format($this->value, $this->decimals, '.', ',') . (($this->suffix) ? ' ' . $this->suffix : '');
                break;

            default:
                return null;
        }
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
     * Clone and Wakeup override to keep the singleton.
     */
    private function __clone()  { }
    private function __wakeup() { }
}