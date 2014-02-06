# Gavel

A PHP library for calculating congress and session values.

## Install

Normal install via Composer.

## Usage

```php
// get congress from year
$congress = Travis\Gavel::from_year(2012)->congress;

// get year from congress
$congress = Travis\Gavel::from_congress($congress, $session)->year;

// get current session
$session = Travis\Gavel::current()->session;

// get current cycle
$cycle = Travis\Gavel::current()->cycle;
```

## Helpers

```php
$bill = 'H.R. 123';
$clean = Travis\Gavel::bill_clean($bill); // returns "HR123"
$split = Travis\Gavel::bill_split($string); // returns array "HR" and "123"
```