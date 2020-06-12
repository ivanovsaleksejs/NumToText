Converts numbers or prices to text representation in English, Latvian or Russian. 
Other languages may be added just by extending class.


### How to install

```bash
composer require ivanovsaleksejs\num-to-text
```

or add to your composer.json

```json
{
    "require": {
        "ivanovsaleksejs\num-to-text": "^2.*"
    }
}
```

and then

```bash
composer install
```

### How to use

```php
include __DIR__ . '/vendor/autoload.php';

use ivanovsaleksejs\NumToText\Num;
use ivanovsaleksejs\NumToText\Price;

echo Num::toText(1234.66, 'EN') . "\n";
// Echoes 'one hundred twenty three thousand four hundred fifty six'

echo Price::toText(123456.78, [['dollars', 'dollar'], ['cents', 'cent']], 'EN', true) . "\n";
// Echoes 'one hundred twenty three thousand four hundred fifty six dollars 78 cents'

echo Price::toText(123456.78, [['dollars', 'dollar'], ['cents', 'cent']], 'EN') . "\n";
// Echoes 'one hundred twenty three thousand four hundred fifty six dollars seventy eight cents'
```

### How to add new language
To add a language, you need to extend main class, for example:

```php
class NumToText_DE extends NumToText{

}
```

### How to add new currency
To add a currency, see the currencies.php file.

### How to run unit tests

```bash
./vendor/bin/phpunit
```