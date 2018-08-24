# MvcCore Extension - Tool - Locale
Properly set and get system locale settings by PHP ` setlocale();` across any system platform.

[![Latest Stable Version](https://img.shields.io/badge/Stable-v4.3.1-brightgreen.svg?style=plastic)](https://github.com/mvccore/ext-tool-locale/releases)
[![License](https://img.shields.io/badge/Licence-BSD-brightgreen.svg?style=plastic)](https://mvccore.github.io/docs/mvccore/4.0.0/LICENCE.md)
![PHP Version](https://img.shields.io/badge/PHP->=5.3-brightgreen.svg?style=plastic)

# Usage

```php
// Windows or Unix - syntax is the same:
$configuredLocale = \MvcCore\Ext\Tools\Locale::SetLocale(LC_ALL, 'nl_NL@euro');
var_dump($configuredLocale);
```
