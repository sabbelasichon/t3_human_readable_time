# Friendly human readable dates ("5 years ago")!

This extension provides one simple thing: takes dates and gives you friendly "2 hours ago" (plural) or "in one minute" (singular) messages.

## Installation

```
composer require ssch/t3-human-readable-time
```

## Usage

In Fluid:

```html
{namespace time=Ssch\T3HumanReadableTime\ViewHelpers}
<time:humanReadableTime from="{from}" to="{to}" />
```

Note: It works alos for dates in the future, too.

### Everywhere else

You can also use it everywhere else i.e. in your Services or Controllers:

```php
use Ssch\T3HumanReadableTime\Contract\DateTimeFormatterInterface;

public function __construct(private readonly DateTimeFormatterInterface $dateTimeFormatter)
{

}
public function yourAction()
{
    $someDate = new \DateTimeImmutable('2023-06-15');
    $now = new \DateTimeImmutable();

    $agoTime = $this->dateTimeFormatter->formatDiff($someDate, $now);
}
```

## Controlling the locale

The extension will automatically use the current locale when translating
the messages like in the famous f:translate ViewHelper. However, you can override the languageKey:

```html
{namespace time=Ssch\T3HumanReadableTime\ViewHelpers}
<time:humanReadableTime from="{from}" to="{to}" languageKey="de" />
```

## Credits
This extension is heavily inspired and copied from [KnpTimeBundle](https://github.com/KnpLabs/KnpTimeBundle)
