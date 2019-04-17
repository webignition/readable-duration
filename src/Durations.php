<?php

namespace webignition\ReadableDuration;

class Durations
{
    const SECONDS_PER_MINUTE = 60;
    const MINUTES_PER_HOUR = 60;
    const HOURS_PER_DAY = 24;
    const DAYS_PER_MONTH = 30; // approximate!
    const MONTHS_PER_YEAR = 12;
    const DAYS_PER_YEAR = 365; // approximate!

    const SECONDS_PER_DAY = self::SECONDS_PER_MINUTE * self::MINUTES_PER_HOUR * self::HOURS_PER_DAY;
    const SECONDS_PER_HOUR = self::SECONDS_PER_MINUTE * self::MINUTES_PER_HOUR;
    const SECONDS_PER_MONTH = self::SECONDS_PER_DAY * self::DAYS_PER_MONTH;
    const SECONDS_PER_YEAR = self::SECONDS_PER_DAY * self::DAYS_PER_YEAR;
}
