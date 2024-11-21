# MvcCore - Extension - Tool - Locale

[![Latest Stable Version](https://img.shields.io/badge/Stable-v5.3.0-brightgreen.svg?style=plastic)](https://github.com/mvccore/ext-tool-locale/releases)
[![License](https://img.shields.io/badge/License-BSD%203-brightgreen.svg?style=plastic)](https://mvccore.github.io/docs/mvccore/5.0.0/LICENSE.md)
![PHP Version](https://img.shields.io/badge/PHP->=5.4-brightgreen.svg?style=plastic)

MvcCore extension to properly set and get system locale settings by PHP ` setlocale();` across any system platform.

## Installation
```shell
composer require mvccore/ext-tool-locale
```

## Usage

```php
// Windows or Unix - syntax is the same:
$configuredLocale = \MvcCore\Ext\Tools\Locale::SetLocale(LC_ALL, 'nl_NL@euro');

var_dump($configuredLocale);
// Windows: Dutch_Netherlands.1252
// Unix: nl_NL@euro
```
