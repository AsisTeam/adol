# ADOL > property and realty API

[![Build Status](https://img.shields.io/travis/com/AsisTeam/adol.svg?style=flat-square)](https://travis-ci.com/AsisTeam/adol)
[![Licence](https://img.shields.io/packagist/l/AsisTeam/adol.svg?style=flat-square)](https://packagist.org/packages/AsisTeam/adol)
[![Downloads this Month](https://img.shields.io/packagist/dm/AsisTeam/adol.svg?style=flat-square)](https://packagist.org/packages/AsisTeam/adol)
[![Downloads total](https://img.shields.io/packagist/dt/AsisTeam/adol.svg?style=flat-square)](https://packagist.org/packages/AsisTeam/adol)
[![Latest stable](https://img.shields.io/packagist/v/AsisTeam/adol.svg?style=flat-square)](https://packagist.org/packages/AsisTeam/adol)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat)](https://github.com/phpstan/phpstan)

## Credits

The development is under [AsisTeam s.r.o.](https://www.asisteam.cz/).
Feel free to use and contribute.

<img src="https://www.asisteam.cz/img/logo.svg" width="200" alt="Asisteam" title="Asisteam"/>

## Install

```
composer require asisteam/adol
```

## Versions

| State       | Version | Branch   | PHP      |
|-------------|---------|----------|----------|
| development | `^0.1`  | `master` | `>= 7.1` |
| production  | `^1.0`  | `master` | `>= 7.1` |

## Overview

This package communicates with ADOL API and allows to perform CRUD calls for realty, estate and insolvency entities.

The `RequestException` is being thrown if request is invalid. The request will not be performed.
`ResponseException` is thrown whenever request has been sent and response from adol server contains invalid status or misses some data.

### API Hlídač nemovitostí - Property watch dog API

To be used for registering properties to watch dog, removing from it and listing existing items.
The `PropertyWatchDog` class should be used for communication with ADOL watch dog.
It provides following methods:
 - insert(IEstate $estate): Insertion
 - list(int $page, ?int $limit = 10): Record[]
 - detail(string $id): Record
 - delete(string $id): void
 
#### Usage

```php
// creating client is easy, just provide your auth token
$client = new PropertyWatchDog('fillYourSecretTokenHere');

// adding new property to watch dog
$land = Land::create(549193, Estate::EVIDENCE_PKN, true, 5);
// we can add more estate fields if we want to
$land->name = 'some land name if available';
$ins = $client->insert($land);
$watchDogId = $ins->getId();

// we can get the detail 'Adol\Result\Propety\WatchDog\Record' of property if we know it's id
$record = $client->detail($watchDogId)

// or we can list multiple records 'Adol\Result\Propety\WatchDog\Record' at once
$records = $client->list(0, 100); // list form 0-100

// to delete record from watch dog, just pass it's id to delete method
$client->delete($watchDogId);

```
