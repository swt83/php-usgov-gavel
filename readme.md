# Gavel for Laravel 3.x

A simple library for converting Congress/Session values into Year/Cycle values, and vice-versa.

## Usage

```
// get congress from year
$congress = Gavel::from_year(2012)->congress;

// get year from congress
$congress = Gavel::from_congress($congress, $session)->year;

// get current session
$session = Gavel::current()->session;

// get current cycle
$cycle = Gavel::current()->cycle;
```

## Helper

```
$bill_number = Gavel::filter('H.R. 123'); // returns HR123
```