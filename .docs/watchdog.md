# Watchdog - API Hlídač nemovitostí

To be used for registering properties to watch dog, removing them from it, listing existing items and checking changes related to them.
The `WatchDog/InsolvencyClient` and `WatchDog\PropertyClient` classes should be used for communication with ADOL watch dog API.

## WatchDog InsolvencyClient

Checks for changes made on insolvency records in Czech insolvency registry.

Provides following methods:
- insert(ISubject $insolvency): Record
- list(int $page, ?int $limit = 10): Record[]
- detail(string $id): Record
- delete(string $id): void
- changes(DateTimeImmutable $from): Change[]

_Note: Record and Changes are objects related specifically to Insolvency API_

### Entities

For easier usage of the Insolvency Watchdog API, there are 2 predefined entities located in `AsisTeam\ADOL\Entity\WatchDog\Insolvency` namespace implementing `ISubject` interface which is required when calling `insert` method.
- Company
- Person

Both entities represent subject that can be the subject of insolvency and provides `create` method, that helps you to create the entity properly with all mandatory fields required by remote API.


### Code examples

_Please see unit tests `tests/Cases/Unit/Client/WatchDog/InsolvencyClientTest.php`, that are good source of knowledge about usage of this library._

```php
// creating client is easy, just provide your auth token
$watchDog = new InsolvencyClient('fillYourSecretTokenHere');

// add a person to watchdog
$record = $client->insert(Person::create('120412/3466', 'Vlasta', 'Burian'));
$watchDogId = $record->getId();

// list what registered in watchdog
$records = $client->list(1);

// see the detail about watchdog record including insolvencies if any
$records = $client->detail($watchDogId);

// show changes since some given date
$changes = $client->changes(new DateTimeImmutable('2019-01-01'));

// remove from watchdog by giving it's internal ID (it is returned in data on insert/list/detail calls)
$watchDog->delete($watchDogId);
```

___

## WatchDog PropertyClient

Checks for changes made on properties/estates (lands, building, building units) in Czech national registries.

Provides following methods:
 - insert(IEstate $estate): Insertion
 - list(int $page, ?int $limit = 10): Record[]
 - detail(string $id): Record
 - delete(string $id): void
 - changes(DateTimeImmutable $from): Changes[]
 
_Note:  Insertion, Record and Changes are objects related specifically to Property API_
 
### Entities

For easier usage of the Property Watchdog API, there are 3 predefined entities in `AsisTeam\ADOL\Entity\WatchDog\Property` namespace implementing `IEstate` interface which is required when calling `insert` method.
- Land
- Building
- BuildingUnit

Every single entity provides `create` method, that helps you to create the entity properly with all mandatory fields required by remote API.
Please see the source code and inline comments in mentioned `create` methods to understand the mandatory values necessary for objects creation.

### Code examples

_Please see unit tests `tests/Cases/Unit/Client/WatchDog/PropertyClientTest.php`, that are good source of knowledge about usage of this library._

```php
// creating client is easy, just provide your auth token
$watchDog = new PropertyClient('fillYourSecretTokenHere');

// adding new property to watch dog
$land = Land::create(549193, Estate::EVIDENCE_PKN, true, 5);
// we can add more estate fields if we want to
$land->name = 'some land name if available';
$ins = $watchDog->insert($land);
$watchDogId = $ins->getId();

// we can get the detail 'Adol\Result\WatchDog\Record' of property if we know it's id
$record = $watchDog->detail($watchDogId)

// or we can list multiple records 'Adol\Result\WatchDog\Record' at once
$records = $watchDog->list(0, 100); // list form 0-100

// get changes identified by watchdog in inserted entitites since given date
$changes = $watchdog->changes(new DateTimeImmutable('2019-01-01'));

// to delete record from watch dog, just pass it's id to delete method
$watchDog->delete($watchDogId);
```
