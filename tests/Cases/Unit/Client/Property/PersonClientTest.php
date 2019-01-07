<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Unit\Client\Property;

use AsisTeam\ADOL\Client\Property\PersonClient;
use AsisTeam\ADOL\Entity\Property\Building;
use AsisTeam\ADOL\Entity\Property\Land;
use AsisTeam\ADOL\Entity\Property\Person;
use AsisTeam\ADOL\Tests\Cases\Unit\Client\Helpers;
use Tester\Assert;
use Tester\Environment;
use Tester\TestCase;

require_once __DIR__ . '/../../../../bootstrap.php';

class PersonClientTest extends TestCase
{

	/**
	 * @throws AsisTeam\ADOL\Exception\ResponseException Response error: "Nejaka chyba"
	 */
	public function testError(): void
	{
		$client = new PersonClient('token', Helpers::createHttpClientMock('property/any_error.json'));
		$client->findPerson(new Person('', ''));
	}

	public function testFindPerson(): void
	{
		$client = new PersonClient('token', Helpers::createHttpClientMock('property/person_find.json'));
		$persons = $client->findPerson(new Person('Tomáš', 'Sedláček'));

		Assert::count(5, $persons);
		foreach ($persons as $person) {
			Assert::type(Person::class, $person);
		}

		$p = $persons[0];
		Assert::equal(4857134101, $p->getId());
		Assert::equal('V podluží 679/2, Nusle, 14000 Praha', $p->getAddress());
		Assert::equal('Ing. Tomáš Sedláček', $p->getFullName());

		$p = $persons[3];
		Assert::equal(4166779101, $p->getId());
		Assert::equal(4166778101, $p->getFirstPartnerId());
		Assert::equal(1806065209, $p->getSecondPartnerId());
		Assert::equal('Za mlýnem 1563/27, Braník, 14700 Praha', $p->getAddress());
		Assert::equal('Sedláček Tomáš Ing. a Sedláčková Dana Ing.', $p->getFullName());
	}

	public function testGetPerson(): void
	{
		$client = new PersonClient('token', Helpers::createHttpClientMock('property/person_get.json'));
		$persons = $client->getPerson(new Person('Tomáš', 'Sedláček'));

		Assert::count(2, $persons);
		foreach ($persons as $person) {
			Assert::type(Person::class, $person);
		}

		$p = $persons[0];
		Assert::equal(40952368010, $p->getId());
		Assert::equal('Boleslavova 415/42, Nusle, 14000 Praha', $p->getAddress());
		Assert::equal('Ing. Tomáš Sedláček', $p->getFullName());

		$p = $persons[1];
		Assert::equal(4857134101, $p->getId());
		Assert::equal('V podluží 679/2, Nusle, 14000 Praha', $p->getAddress());
		Assert::equal('Ing. Tomáš Sedláček', $p->getFullName());
	}

	public function testGetLands(): void
	{
		$client = new PersonClient('token', Helpers::createHttpClientMock('property/person_lands.json'));
		$lands = $client->getLands(538364604);

		Assert::count(6, $lands);
		foreach ($lands as $land) {
			Assert::type(Land::class, $land);
		}

		Assert::equal('PKN St. 208/3', $lands[0]->getObjectLabel());
		Assert::equal('PKN St. 4254', $lands[5]->getObjectLabel());
	}

	public function testGetBuildings(): void
	{
		$client = new PersonClient('token', Helpers::createHttpClientMock('property/person_buildings.json'));
		$buildings = $client->getBuildings(538364604);

		Assert::count(3, $buildings);
		foreach ($buildings as $building) {
			Assert::type(Building::class, $building);
			Assert::equal(659541, $building->getCadastralAreaCode());
		}

		// first building
		Assert::equal(267516604, $buildings[0]->getId());
		Assert::equal('budova s číslem popisným', $buildings[0]->getObjectType());
		Assert::equal('objekt k bydlení', $buildings[0]->getUsage());
		Assert::equal('Jičín', $buildings[0]->getRegion());
		Assert::equal('Jičín', $buildings[0]->getMunicipality());
		Assert::equal('Valdické Předměstí', $buildings[0]->getMunicipalityPart());
		Assert::equal('1/2', $buildings[0]->getOwnerShare());

		// second building
		Assert::equal(269692604, $buildings[1]->getId());
		Assert::equal('budova s číslem popisným', $buildings[1]->getObjectType());
		Assert::equal('stavba pro administrativu', $buildings[1]->getUsage());
		Assert::equal('Jičín', $buildings[1]->getRegion());
		Assert::equal('Jičín', $buildings[1]->getMunicipality());
		Assert::equal('Holínské Předměstí', $buildings[1]->getMunicipalityPart());
		Assert::equal('1/1', $buildings[1]->getOwnerShare());

		// third building - does not have region/municipality/municipalityPart filled
		Assert::equal(497115604, $buildings[2]->getId());
		Assert::equal('budova bez čísla popisného nebo evidenčního', $buildings[2]->getObjectType());
		Assert::equal('garáž', $buildings[2]->getUsage());
		Assert::equal('', $buildings[2]->getRegion());
		Assert::equal('', $buildings[2]->getMunicipality());
		Assert::equal('', $buildings[2]->getMunicipalityPart());
		Assert::equal('1/1', $buildings[2]->getOwnerShare());
	}

	public function testGetBuildingUnits(): void
	{
		Environment::skip('no data provided by API so far.');

		$client = new PersonClient('token', Helpers::createHttpClientMock('property/person_units.json'));
		$client->getUnits(538364604);
	}

}

(new PersonClientTest())->run();
