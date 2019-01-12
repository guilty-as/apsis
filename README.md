# APSIS PHP API Client

[![Latest Version on Packagist](https://img.shields.io/packagist/v/guilty/apsis.svg?style=flat-square)](https://packagist.org/packages/guilty/apsis)
[![Total Downloads](https://img.shields.io/packagist/dt/guilty/apsis.svg?style=flat-square)](https://packagist.org/packages/guilty/apsis)


APSIS API client, used for interacting with the [APSIS](https://www.apsis.com/) API: http://se.apidoc.anpdm.com


## Installation

You can install the package via composer:

```bash
composer require guilty/apsis
```


## Usage

### Available services
``` php

use \Guilty\Apsis\Factory;

$apiKey = "YOUR-API-KEY";
$accountService = Factory::create($apiKey)->account()
$eventService = Factory::create($apiKey)->event()
$subscriberService = Factory::create($apiKey)->subscriber()
$openService = Factory::create($apiKey)->open()
$bounceService = Factory::create($apiKey)->bounce()
$smsService = Factory::create($apiKey)->sms()
$filterService = Factory::create($apiKey)->filter()
$transactionalService = Factory::create($apiKey)->transactional()
$folderService = Factory::create($apiKey)->folder()
$clickService = Factory::create($apiKey)->click()
$mailingListService = Factory::create($apiKey)->mailingList()
$newsletterService = Factory::create($apiKey)->newsletter()
$sendingService = Factory::create($apiKey)->sending()
$optOutService = Factory::create($apiKey)->optOut()

```

### Implemented Services

These services are currently implemented, the rest is being worked on and will be checked off once completed.

- [x] Account
- [x] Bounce
- [x] Click
- [x] Event
- [x] Filter
- [x] Folder
- [ ] Import
- [x] MailingList
- [x] Newsletter
- [x] Open
- [x] OptOut
- [x] Sending
- [x] Sms
- [x] Subscriber
- [x] Transactional (**NOTE**: sendTransactionalEmail(), might not work right yet)


### Security

If you discover any security related issues, please email tech@guilty.no instead of using the issue tracker.


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

--- 

Brought to you by [Guilty AS](https://guilty.no)

The APSIS logo and Trademark is the property of [APSIS International AB](https://www.apsis.com/)
