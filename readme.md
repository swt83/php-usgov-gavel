# Congress for LaravelPHP

A simple library for converting dates into congress/session number pairs, and vice versa.

## Usage

```
// get from year
$congress = Congress::from_year(2012);

// get from congress
$congress = Congress::from_congress($congress, $session);

// get current
$congress = Congress::current();
```

Returns an object containing ``congress``, ``session``, ``year``, and ``cycle`` values.

## Helper

```
$bill_number = Congress::filter('H.R. 123'); // returns HR123
```