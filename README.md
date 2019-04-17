readable-duration
=================

Ever wondered how long a value in seconds might be in units that your human brain can more comfortably understand?

Now you can convert a value in seconds into a human-readable convenience duration!

Features:

 - Get the number of years, months, days, hours, minutes and seconds for a given value
 - Get a value in seconds in years, months, days, hours, minutes or seconds
 - Get a value in seconds as the most appropriate human-readable value

## Get the number of years, months, days, hours, minutes and seconds for a given value

```php
<?php
use webignition\ReadableDuration\Factory;

/**
 * 100000 seconds is 1 day, 3 hours, 46 minutes and 40 seconds
 */
$factory = new Factory();    
$readableDuration = $factory->create(100000);

$readableDuration->getDays();
// 1

$readableDuration->getHours();
// 3

$readableDuration->getMinutes();
// 46

$readableDuration->getSeconds();
// 40
```    
    
## Get a value in seconds in years, months, days, hours, minutes or seconds

```php
<?php

use webignition\ReadableDuration\Factory;

/**
 * 100000 seconds as years, months, days, hours, minute or seconds
 *
 * Note: these are human-readable convenience representations not exact
 *
 * 100000 seconds is strictly 1.16 days. As far as convenience is concerned, that's 1 day.
 * 100000 seconds is strictly 27.78 hours. As far as convenience is concerned, that's 28 hours.
 */
$factory = new Factory();    
$readableDuration = $factory->create(100000);

$readableDuration->getInYears();
// 0

$readableDuration->getInMonths();
// 0

$readableDuration->getInDays();
// 1

$readableDuration->getInHours();
// 28

$readableDuration->getInMinutes();
// 1667

$readableDuration->getInSeconds();
// 100000

```

## Get a value in seconds as the most appropriate human-readable value

```php
<?php

use webignition\ReadableDuration\Factory;

/**
 * 100000 seconds:
 *
 * - represented as a single time unit is 1 day
 * - represented as two time units is 1 day 4 hours
 * - represented as three time units is 1 day 3 hours 47 minutes
 *
 */
$factory = new Factory();    
$readableDuration = $factory->create(100000);

/**
 * 100000 seconds, as a single time unit is 1 day
 */
$this->factory->getInMostAppropriateUnits($readableDuration);
// [
//     [
//         'unit' => 'day',
//         'value' => 1
//     ]
// ]


/**
 * 100000 seconds, as two time units is 1 day 4 hours
 */
$this->factory->getInMostAppropriateUnits($readableDuration, 2);
// [
//     [
//         'unit' => 'day',
//         'value' => 1
//     ],
//     [
//         'unit' => 'hour',
//         'value' => 4
//     ]
// ]

/**
 * 100000 seconds, as three time units is 1 day 3 hours 47 minutes
 */
$this->factory->getInMostAppropriateUnits($readableDuration, 3);
// [
//     [
//         'unit' => 'day',
//         'value' => 1
//     ],
//     [
//         'unit' => 'hour',
//         'value' => 3
//     ],
//     [
//         'unit' => 'minute',
//         'value' => 47
//     ]
// ]
```
