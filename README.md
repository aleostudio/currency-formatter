# Simple Currency Formatter package

A simple singleton instance with **fluent methods** to format a float price with the right currency syntax, adding to it an optional suffix or prefix and specifying the decimals number.

## Convert a integer/float value to a formatted currency:

```sh
CurrencyFormatter::set('EUR')->value(1000.46)->format();
```
- Will return the formatted string: **€ 1.000,46**
```sh
CurrencyFormatter::set('EUR')->value(1000.46)->withPrefix('EURO')->decimals(3)->format();
```
- Will return the formatted string: **EURO 1.000,460**
```sh
CurrencyFormatter::set('EUR')->value(1000.46)->withSuffix('Eur')->format();
```
- Will return the formatted string: **1.000,46 Eur**
```sh
CurrencyFormatter::set('USD')->value(1000.46)->withPrefix('$')->format();
```
- Will return the formatted string: **$ 1,000.46**
```sh
CurrencyFormatter::set('USD')->value(1000.46)->withPrefix('USD')->decimals(3)->format();
```
- Will return the formatted string: **USD 1,000.460**
```sh
CurrencyFormatter::set('USD')->value(1000.46)->withSuffix('USD')->format();
```
- Will return the formatted string: **1,000.46 USD**

## Convert a currency string to a valid float value

```sh
CurrencyFormatter::toFloat('EUR 1.000,45');
```
- Will return the float value: **1000.45**
```sh
CurrencyFormatter::toFloat('1,000.45 USD');
```
- Will return the float value: **1000.45**


## Installation

Clone the package with the command:
```sh
git clone git@github.com:aleostudio/currency-formatter.git
```
Install its dependencies with:
```sh
composer install
```
---
Then create a new php file and try this code below
```sh
require_once __DIR__ . '/vendor/autoload.php';

use AleoStudio\CurrencyFormatter\CurrencyFormatter;

echo CurrencyFormatter::set('EUR')->value(1000.46)->format() . '<br />';
echo CurrencyFormatter::set('EUR')->value(1000.46)->withPrefix('EURO')->decimals(3)->format() . '<br />';
echo CurrencyFormatter::set('EUR')->value(1000.46)->withSuffix('Eur')->format() . '<br />';

echo CurrencyFormatter::set('USD')->value(1000.46)->withPrefix('$')->format() . '<br />';
echo CurrencyFormatter::set('USD')->value(1000.46)->withPrefix('USD')->decimals(3)->format() . '<br />';
echo CurrencyFormatter::set('USD')->value(1000.46)->withSuffix('USD')->format() . '<br />';

echo CurrencyFormatter::toFloat('EUR 1.000,45') . '<br />';
echo CurrencyFormatter::toFloat('1,000.45 USD') . '<br />';
```
---
## Unit testing

Install PHPUnit and then run the test with the command:
```sh
phpunit --bootstrap vendor/autoload.php tests/CurrencyFormatterTest.php 
```
---
This **README** was generated with: **https://stackedit.io/app**
