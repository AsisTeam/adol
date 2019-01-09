# Watchdog - API Hlídač nemovitostí

To be used for registering properties to watch dog, removing from it and listing existing items.
The `WatchDog` class should be used for communication with ADOL watch dog.
It provides following methods:
 - insert(IEstate $estate): Insertion
 - list(int $page, ?int $limit = 10): Record[]
 - detail(string $id): Record
 - delete(string $id): void
 
#### Usage

```php
// creating client is easy, just provide your auth token
$watchDog = new WatchDog('fillYourSecretTokenHere');

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

// to delete record from watch dog, just pass it's id to delete method
$watchDog->delete($watchDogId);

```
