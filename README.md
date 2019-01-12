# APSIS PHP API Client

[![Latest Version on Packagist](https://img.shields.io/packagist/v/guilty/apsis.svg?style=flat-square)](https://packagist.org/packages/guilty/apsis)
[![Total Downloads](https://img.shields.io/packagist/dt/guilty/apsis.svg?style=flat-square)](https://packagist.org/packages/guilty/apsis)


APSIS API client, used for interacting with the [APSIS](https://www.apsis.com/) API: http://se.apidoc.anpdm.com


## Installation

You can install the package via composer:

```bash
composer require guilty/apsis
```


## API Usage

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

### Account Service
```
$apiKey = "YOUR-API-KEY";
$accountService = Factory::create($apiKey)->account()
$accountService->createSingleSignOnUrl();
$accountService->getDemographicData();
```

### Bounce Service
```
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
```
$apiKey = "YOUR-API-KEY";
$clickService = Factory::create($apiKey)->click()
$clickService->getClicksBySendqueueIdPaginated($sendQueueId, $pageNumber, $pageSize)
```

### Event Service
```
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
```
$apiKey = "YOUR-API-KEY";
$filterService = Factory::create($apiKey)->filter()
$filterService->createFilterByDemographicData($filterName, $demographicDataName, $operatorValue, $demographicDataValue)
$filterService->getAllFilters()
```


### Folder Service
```
$apiKey = "YOUR-API-KEY";
$folderService = Factory::create($apiKey)->folder()
$filterService->createFilterByDemographicData($filterName, $demographicDataName, $operatorValue, $demographicDataValue)
$filterService->createFolder($folderName, $folderType)
$filterService->getAllFolders()
```

### Mailing List Service
```
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
```
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
```
$apiKey = "YOUR-API-KEY";
$openService = Factory::create($apiKey)->open()
$openService->getOpensBySendqueueIdPaginated($sendQueueId, $pageNumber, $pageSize)
```

### Opt Out Service
```
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
```
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
```
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
```
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
```
$apiKey = "YOUR-API-KEY";
$transactionalService = Factory::create($apiKey)->transactional()
$transactionalService->getTransactionalBounces($projectId, \DateTimeInterface $dateFrom = null, \DateTimeInterface $dateTo = null)
$transactionalService->getTransactionalClicks($projectId, \DateTimeInterface $dateFrom = null, \DateTimeInterface $dateTo = null)
$transactionalService->getTransactionalOpens($projectId, \DateTimeInterface $dateFrom = null, \DateTimeInterface $dateTo = null)
$transactionalService->getTransactionalProjects()
$transactionalService->getTransactionResult($transactionId, $includeDemographicData)
$transactionalService->sendTransactionalEmail($projectId, TransactionalEmail $transactionalEmail, \DateTimeInterface $sendDate = null, $allowInactiveProjects = true)
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
