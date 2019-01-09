# Property API - API SLUŽBY MAJETEK

This API allows you to check information about which is then converted to adequate entity:
 - `lands` (parcely) -> `Entity\Property\Land`
 - `buildings` (budovy) -> `Entity\Property\Building`
 - `building units` (jednotky) -> `Entity\Property\BuildingUnit`
 - `persons` (osoby) -> `Entity\Property\Person`

For each of entities above the special client class with corresponding public methods is created.

- `src/Client/Property/LandClient.php`
- `src/Client/Property/BuildingClient.php`
- `src/Client/Property/BuildingUnitClient.php`
- `src/Client/Property/PersonClient.php`

Just pass a valid `token` to Client class constructor and you are ready to go.

Except entites above the `Entity\Property\Ownership` (details about owners, their shares etc) and `Entity\Property\Sentence` (objects legal sentences) entities exist. 

### LandClient

#### Methods
- findLands (returns a list of lands matching given params)
- getLand (returns details of single land by it's id)
- getOwnerships (returns a list of ownership details)
- getBuilding (returns a list of building on given land)
- getSentences (returns a list of related legal sentences for given land)

### BuildingClient

#### Methods
- findBuildings (returns a list of buildings matching given params)
- getBuilding (returns details of single building by it's id)
- getOwnerships (returns a list of ownership details)
- getUnits (returns a list of building units in given building)
- getSentences (returns a list of related legal sentences for given building)

### BuildingUnitClient

#### Methods
- findBuildingUnits (returns a list of buildings units matching given params)
- getUnit (returns details of single building unit by it's id)
- getOwnerships (returns a list of ownership details)
- getSentences (returns a list of related legal sentences for given building unit)

### PersonClient

#### Methods
- findPerson (returns a list of persons matching given params)
- getPerson (returns details of single person by it's id)
- getLands (returns a list of lands owned by given person)
- getBuildings (returns a list of buildings owned by given person)
- getBuildingUnits (returns a list of building units owned by given person)

For further details see [Original API docs](https://github.com/AsisTeam/adol/blob/master/.docs/misc/MajetekAPI.pdf)

See unit tests to understand how to use particular Clients and returned entity objects.

