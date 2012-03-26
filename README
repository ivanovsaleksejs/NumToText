Converts numbers or prices to text representation in English, Latvian or Russian. 
Other languages may be added just by extending class.


Usage:

1) echo NumToText(123456, 'EN');
// Echoes 'one hundred twenty three thousand four hundred fifty six'

2) echo PriceToText(123456.78, array(array('dollars', 'dollar'), array('cents', 'cent')), 'EN', true);
// Echoes 'one hundred twenty three thousand four hundred fifty six dollars 78 cents'

3) echo PriceToText(123456.78, array(array('dollars', 'dollar'), array('cents', 'cent')), 'EN');
// Echoes 'one hundred twenty three thousand four hundred fifty six dollars seventy eight cents'

To add a language, you need to extend main class, for example:

class NumToText_DE extends NumToText{

}

To add a currency, see the currencies.php file.