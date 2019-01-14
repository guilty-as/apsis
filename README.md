# APSIS PHP API Client

[![Latest Version on Packagist](https://img.shields.io/packagist/v/guilty/apsis.svg?style=flat-square)](https://packagist.org/packages/guilty/apsis)
[![Total Downloads](https://img.shields.io/packagist/dt/guilty/apsis.svg?style=flat-square)](https://packagist.org/packages/guilty/apsis)


APSIS API client, used for interacting with the [APSIS](https://www.apsis.com/) API: http://se.apidoc.anpdm.com


## Installation

You can install the package via composer:

```bash
composer require guilty/apsis
```


## Laravel

This package is compatible with Laravel

You can publish the config file like so
```
php artisan vendor:publish --provider="Guilty\Apsis\ApsisServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
    /*
     * This is the API key for your APSIS account.
     * Read how to generate an api key here:
     * http://se.apidoc.anpdm.com/Help/GettingStarted/Getting%20started
     */
    "api_key" => env("APSIS_API_KEY")
];
```

To get started, add the following environment variable to your .env file:

```
APSIS_API_KEY="your-api-key"
```


You can use the facade like so:
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function index()
    {
        $newsletters = Apsis::newsletter()->getNewslettersPaginated(1, 10);
                   
        return view('home', [
            "newsletters" => $newsletters->Result->Items
        ]);
    }
}

```


## API Usage

### Available services
```php

use \Guilty\Apsis\Factory;

$apiKey = "YOUR-API-KEY";

// Create a factory like so
$factory = Factory::create($apiKey);

// Then fetch the service you need
$accountService = $factory->account()
$eventService = $factory->event()
$subscriberService = $factory->subscriber()
$openService = $factory->open()
$bounceService = $factory->bounce()
$smsService = $factory->sms()
$filterService = $factory->filter()
$transactionalService = $factory->transactional()
$folderService = $factory->folder()
$clickService = $factory->click()
$mailingListService = $factory->mailingList()
$newsletterService = $factory->newsletter()
$sendingService = $factory->sending()
$optOutService = $factory->optOut()
```

### Account Service
```php
$apiKey = "YOUR-API-KEY";
$accountService = Factory::create($apiKey)->account()
$accountService->createSingleSignOnUrl();
$accountService->getDemographicData();
```

### Bounce Service
```php
$apiKey = "YOUR-API-KEY";
$bounceService = Factory::create($apiKey)->bounce()
$bounceService->getAll()
$bounceService->getAllPaginated($pageNumber, $pageSize)
$bounceService->getBouncesForSendingPaginated($sendQueueId, $pageNumber, $pageSize)
$bounceService->getByDateInterval(\DateTimeInterface $start, \DateTimeInterface $end)
$bounceService->getByDateIntervalPaginated(\DateTimeInterface $start, \DateTimeInterface $end, $pageNumber, $pageSize)
$bounceService->getBySendqueueIds($sendqueueIds)
```

### Click Service
```php
$apiKey = "YOUR-API-KEY";
$clickService = Factory::create($apiKey)->click()
$clickService->getClicksBySendqueueIdPaginated($sendQueueId, $pageNumber, $pageSize)
```

### Event Service
```php
$apiKey = "YOUR-API-KEY";
$eventService = Factory::create($apiKey)->event()
$eventService->addAttendee($eventId, $sessionId, $attendeeData)
$eventService->getAttendees($eventId, $sessionId = null, $attendeeStatus = null)
$eventService->getControls($eventId)
$eventService->getEventParticipantStatus($eventId)
$eventService->getEvents()
$eventService->getEventSessionAttendee($eventId, $sessionId, $attendeeEmail)
$eventService->getEventsWithSessions($filters = null)
$eventService->getEventWithSessions($eventId)
$eventService->getOptionsDataCategories($eventId)
$eventService->registerAttendee($eventId, $sessionId, $attendeeData)
$eventService->updateAttendee($eventId, $sessionId, $attendeeId, $attendeeData)
$eventService->updateAttendeeStatus($eventId, $attendeeId, $attendeeStatus)
```

### Filter Service
```php
$apiKey = "YOUR-API-KEY";
$filterService = Factory::create($apiKey)->filter()
$filterService->createFilterByDemographicData($filterName, $demographicDataName, $operatorValue, $demographicDataValue)
$filterService->getAllFilters()
```


### Folder Service
```php
$apiKey = "YOUR-API-KEY";
$folderService = Factory::create($apiKey)->folder()
$filterService->createFilterByDemographicData($filterName, $demographicDataName, $operatorValue, $demographicDataValue)
$filterService->createFolder($folderName, $folderType)
$filterService->getAllFolders()
```

### Mailing List Service
```php
$apiKey = "YOUR-API-KEY";
$mailingListService = Factory::create($apiKey)->mailingList()
$mailingListService->createMailinglist($mailingListDetails)
$mailingListService->createSingleSubscription($mailinglistId, $subscriberId)
$mailingListService->createSubscriptions($mailinglistId, $recipientIds)
$mailingListService->deleteAllMailinglistSubscriptions($mailinglistId)
$mailingListService->deleteAllSubscriptionsForSubscriber($subscriberId)
$mailingListService->deleteMultipleMailingLists($mailinglistIds)
$mailingListService->deleteSingleSubscription($mailinglistId, $subscriberId)
$mailingListService->getAllMailingLists()
$mailingListService->getMailingListDetails($mailinglistId)
$mailingListService->getMailinglistsPaginated($pageNumber, $pageSize)
$mailingListService->getMailinglistSubscribers($mailinglistId, $allDemographics = false, $fieldNames = [])
$mailingListService->getMailinglistSubscribersPaginated($mailingListId, $pageNumber, $pageSize)
$mailingListService->getMailinglistSubscribersWithFilter($mailinglistId, $filterId, $allDemographics = false, $fieldNames = [])
$mailingListService->getMailinglistSubscriptionCount($mailinglistId)
$mailingListService->updateMailingList($mailinglistId, $mailingListDetails)
```

### Newsletter List Service
```php
$apiKey = "YOUR-API-KEY";
$newsletterListService = Factory::create($apiKey)->newsletter()
$newsletterListService->createNewsletter($newsletterData)
$newsletterListService->deleteMultipleNewsletters($newsletterIds)
$newsletterListService->deleteSingleNewsletter($newsletterId)
$newsletterListService->getAllNewsletters()
$newsletterListService->getNewsletterLinks($newsletterId)
$newsletterListService->getNewslettersPaginated($pageNumber, $pageSize)
$newsletterListService->getNewsletterWebVersionLink($newsletterId)
$newsletterListService->updateNewsletter($newsletterId, $newsletterData)
```

### Open Service
```php
$apiKey = "YOUR-API-KEY";
$openService = Factory::create($apiKey)->open()
$openService->getOpensBySendqueueIdPaginated($sendQueueId, $pageNumber, $pageSize)
```

### Opt Out Service
```php
$apiKey = "YOUR-API-KEY";
$optOutService = Factory::create($apiKey)->optOut()
$optOutService->deleteSubscriberFromOptOutAllByEmail($subscriberEmail)
$optOutService->deleteSubscribersFromOptOutAll($subscriberIds)
$optOutService->deleteSubscribersFromOptOutAllByEmail($subscriberEmails)
$optOutService->deleteSubscribersFromOptOutListByEmail($mailinglistId, $subscriberEmails)
$optOutService->getOptOutAll()
$optOutService->getOptOutAllByDateInterval(\DateTimeInterface $start, \DateTimeInterface $end)
$optOutService->getOptOutAllByDateIntervalPaginated(\DateTimeInterface $start, \DateTimeInterface $end, $pageNumber, $pageSize)
$optOutService->getOptOutAllPaginated($pageNumber, $pageSize)
$optOutService->getOptOutList($mailinglistId)
$optOutService->getOptOutListByMailingListPaginated($mailinglistId, $pageNumber, $pageSize)
$optOutService->getOptOutListBySendqueueId($sendQueueId)
$optOutService->getOptOutListBySendqueueIdPaginated($sendQueueId, $pageNumber, $pageSize)
$optOutService->moveSubscribersToOptOutList($mailinglistId, $optOutListSubscriberItems)
$optOutService->optOutAllSubscribers($optOutListSubscriberItems)
```

### Sending Service
```php
$apiKey = "YOUR-API-KEY";
$sendingService = Factory::create($apiKey)->sending()
$sendingService->deleteSendingById($sendQueueId)
$sendingService->getBounces($sendQueueId, \DateTimeInterface $dateFrom, \DateTimeInterface $dateTo)
$sendingService->getClicks($sendQueueId, \DateTimeInterface $dateFrom, \DateTimeInterface $dateTo)
$sendingService->getFutureSendings()
$sendingService->getOpens($sendQueueId, \DateTimeInterface $dateFrom, \DateTimeInterface $dateTo)
$sendingService->getOptOuts($sendQueueId, \DateTimeInterface $dateFrom, \DateTimeInterface $dateTo)
$sendingService->getPaginated($pageNumber, $pageSize)
$sendingService->getSendingById($sendQueueId)
$sendingService->getSendingsByDateInterval(\DateTimeInterface $start, \DateTimeInterface $end)
$sendingService->getSendingsByNewsletterId($newsletterId)
$sendingService->getSendingsBySubscriberId($subscriberId, $pageNumber, $pageSize)
$sendingService->sendNewsletter($newsletterDetails)
```

### Sms Service
```php
$apiKey = "YOUR-API-KEY";
$smsService = Factory::create($apiKey)->sms()
$smsService->createSmsMessage($name, $text, $folderId = null)
$smsService->getIncomingSmsMessages($numberRespondedTo, \DateTimeInterface $start, \DateTimeInterface $end)
$smsService->getSmsCredits()
$smsService->getSmsMessages()
$smsService->getSmsRecipientsBySendQueueId($sendQueueId)
$smsService->send($message, $countryCode, $phoneNumber, $senderName = null, $isLinked = false, \DateTimeInterface $sendDate = null)
$smsService->sendSmsMessage($smsMessageId, $mailingListIds, $senderName = null,
```

### Subscriber Service
```php
$apiKey = "YOUR-API-KEY";
$subscriberService = Factory::create($apiKey)->subscriber()
$subscriberService->createSubscriber($mailingListId, $updateIfExists, $subscriber)
$subscriberService->createSubscribers($mailinglistId, $subscribers)
$subscriberService->createSubscriberWithDoubleOptIn($mailinglistId, $subscriber)
$subscriberService->deleteMultipleSubscribersByEmail($subscriberEmails)
$subscriberService->deleteMultipleSubscribersById($subscriberIds)
$subscriberService->getAllSubscribers($allDemographics = true, $fieldNames = [])
$subscriberService->getAllSubscribersWithFilter($filterId, $allDemographics = true, $fieldNames = [])
$subscriberService->getAllSubscribersWithoutSubscription($allDemographics = true, $fieldNames = [])
$subscriberService->getRecipientsBySendQueueId($sendQueueId)
$subscriberService->getSubscriberDetailsById($subscriberId)
$subscriberService->getSubscriberIdByEmail($email)
$subscriberService->getSubscriberMailinglists($subscriberId)
$subscriberService->getSubscribersByExternalId($externalId)
$subscriberService->getSubscribersPaginated($pageNumber, $pageSize)
$subscriberService->updateSubscribers($subscribers)
```

### Transactional Service
```php
$apiKey = "YOUR-API-KEY";
$transactionalService = Factory::create($apiKey)->transactional()
$transactionalService->getTransactionalBounces($projectId, \DateTimeInterface $dateFrom = null, \DateTimeInterface $dateTo = null)
$transactionalService->getTransactionalClicks($projectId, \DateTimeInterface $dateFrom = null, \DateTimeInterface $dateTo = null)
$transactionalService->getTransactionalOpens($projectId, \DateTimeInterface $dateFrom = null, \DateTimeInterface $dateTo = null)
$transactionalService->getTransactionalProjects()
$transactionalService->getTransactionResult($transactionId, $includeDemographicData)
$transactionalService->sendTransactionalEmail($projectId, TransactionalEmail $transactionalEmail, \DateTimeInterface $sendDate = null, $allowInactiveProjects = true)
```


### Queued Methods

To make it easier to work with [Queued Methods](http://se.apidoc.anpdm.com/Help/QueuedMethods/About%20queued%20methods), you can use the QueuedMethodHelper to poll and retrieve data from any queued method. 

Just pass the response of a Queued Method into the ```QueuedMethodHelper::fromJson()``` method and you will have an instance.
 
Below is an example of how you could use this: 

```php

$factory = \Guilty\Apsis\Factory::create("YOUR-API-KEY");
$newsletterService = $factory->newsletter();

// 'deleteMultipleNewsletters' is a queued method.
$response = $newsletterService->deleteMultipleNewsletters([1, 2, 3, 4]);

// Pass the QueuedMethodHelper the response from a queued method.
$poll = QueuedMethodHelper::fromJson($response, $factory->getClient());

while (true) {
    echo "Polling: {$poll->getPollUrl()}";

    try {
        // Poll for latest status
        $poll->poll();

        // Check if the data is ready now.
        if ($poll->isDataReady()) {
            continue; // Jump out of loop if it is.
        }

        // Wait 1 second
        sleep(1);
    } catch (Exception $e) {
        die("Something unexpected happened...");
    }
}

// Fetch the data
$queuedMethodDataResult = $poll->retrieveData();
```


## Implemented Services

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
