# ADOL API - property and realty API and watchdog

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

This package communicates with following ADOL APIs:
- [Watchdog](https://github.com/AsisTeam/adol/blob/master/.docs/watchdog.md) (to be used for assigning watchdog items (insolvencies and estates) to watchdog and checking changes made on these items.)
- [Property](https://github.com/AsisTeam/adol/blob/master/.docs/property.md) (to be used for retrieving detail information about property entities (lands/buildings/building units/persons))

_Note: In order to communicate with ADOL APIs you must have your own private `token` string. This `token` is provided by ADOL._

### Basic principles

For every provided API a separate client class is created (please see `Client/WatchDog/...`, `Client/Property/...`).
In order to create the client, you must instantiate it by passing at least a valid `token` string to it's constructor.
Or you can replace the default GuzzleHttp client with your custom http client that implements ClientInterface.
If using GuzzleHttp client you can also pass a third optional constructor parameter, that is a request options array that will be appended to every request made by the http client.
By using this options array, you can set client timeouts etc. for all client calls. Please see available Guzzle options at http://docs.guzzlephp.org/en/stable/request-options.html.

When doing a call two exceptions can be thrown.

- The `RequestException` is being thrown if request is invalid. The request will not be performed.
- The `ResponseException` is thrown whenever request has been sent and response from ADOL server contains invalid status or misses some data.

### How to run tests and check code

Code quality assurance: `composer qa`
Code PHPSTAN: `composer phpstan`

Unit and Integration tests: `composer tests`

Note: As you are charged for all request performed to real API, integration tests are skipped by default. In order to run integration tests edit `tests/Cases/Integration/AbstractTestCase`
and fill your private `token` and delete `Environment::skip` line in setUp() method.
 

### Nette bridge

You can configure clients as Nette Framework DI services and you will be able to use following services:

__Watchdog API__
- adol.watchdog.insolvency
- adol.watchdog.property

__Property API__
- adol.property.land
- adol.property.building
- adol.property.building_unit
- adol.property.person

```
extensions:
    adol: AsisTeam\ADOL\Bridges\Nette\DI\AdolExtension
    
adol:
    token: "your dedicated adol token"
    options: [
        timeout: 20 
    ]
```
