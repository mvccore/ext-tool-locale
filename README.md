# ext-tool-locales
Properly set and get system locale settings by PHP ` setlocale();` across any system platform.

# Usage

```php
// Windows or Unix - syntax is the same:
$configuredLocale = \MvcCore\Ext\Tools\Locale::SetLocale(LC_ALL, 'nl_NL@euro');
var_dump($configuredLocale);
```
