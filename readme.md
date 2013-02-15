# Gavel for Laravel 3.x

A simple library for converting dates into congress/session number pairs, and vice versa.

## Usage

```
// get congress from year
$congress = Congress::from_year(2012)->congress;

// get year from congress
$congress = Congress::from_congress($congress, $session)->year;

// get current session
$session = Congress::current()->session;

// get current cycle
$cycle = Congress::current()->cycle;
```

## Helper

```
$bill_number = Congress::filter('H.R. 123'); // returns HR123
```