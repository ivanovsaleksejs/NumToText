# NumToText

Converts numbers or prices to text representation in various languages.

### Supported languages

Currently, library supports these languages:

* English
* Russian
* Latvian

French and Spanish are in progress.

### How to install

```bash
composer require ivanovsaleksejs/num-to-text:dev-master
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

echo Num::toText(1234, 'EN') . "\n";
// Echoes 'one thousand two hundred thirty four'

echo Price::toText(123456.78, [['dollars', 'dollar'], ['cents', 'cent']], 'EN', true) . "\n";
// Echoes 'one hundred twenty three thousand four hundred fifty six dollars 78 cents'

echo Price::toText(123456.78, [['dollars', 'dollar'], ['cents', 'cent']], 'EN') . "\n";
// Echoes 'one hundred twenty three thousand four hundred fifty six dollars seventy eight cents'
```

### How to add new language
To add a language, you need to:
* extend main class NumToText (to make sure shorthand functions work, add the code of the language in caps after underscore to the name of new class, for example, NumToText\_DE)
* define functions `digitToWord` and `toWords`
* override some other functions of main class if necessary.

### How to run unit tests

```bash
./vendor/bin/phpunit
```
