# Adapter for Doctrine

[![Latest Version](https://img.shields.io/github/release/hmonglee/php-translation-doctrine-storage.svg?style=flat-square)](https://github.com/hmonglee/php-translation-doctrine-storage/releases)
[![Build Status](https://img.shields.io/travis/phmonglee/php-translation-doctrine-storage.svg?style=flat-square)](https://travis-ci.org/hmonglee/php-translation-doctrine-storage)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/hmonglee/php-translation-doctrine-storage.svg?style=flat-square)](https://scrutinizer-ci.com/g/hmonglee/php-translation-doctrine-storage)
[![Quality Score](https://img.shields.io/scrutinizer/g/hmonglee/php-translation-doctrine-storage.svg?style=flat-square)](https://scrutinizer-ci.com/g/hmonglee/php-translation-doctrine-storage)
[![Total Downloads](https://img.shields.io/packagist/dt/hmonglee/php-translation-doctrine-storage.svg?style=flat-square)](https://packagist.org/packages/hmonglee/php-translation-doctrine-storage)

This is an PHP-translation adapter for Doctrine ([https://www.doctrine-project.org/](https://www.doctrine-project.org/)).

### Install

```bash
composer require hmonglee/php-translation-doctrine-storage
```

##### Symfony bundle

If you want to use the Symfony bundle you may activate it in kernel:
```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Translation\PlatformAdapter\Loco\Bridge\Symfony\TranslationAdapterDoctrineBundle(),
    );
}
```


This will produce a service named `php_translation.adapter.doctrine` that could be used in the configuration for
the [Translation Bundle](https://github.com/php-translation/symfony-bundle).

### Documentation

Read our documentation at [http://php-translation.readthedocs.io](http://php-translation.readthedocs.io/en/latest/).

### Contribute

Do you want to make a change? Pull requests are welcome.
