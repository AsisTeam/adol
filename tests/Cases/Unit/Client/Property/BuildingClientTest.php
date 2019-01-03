<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Unit\Client\Property;

use AsisTeam\ADOL\Client\Property\BuildingClient;
use AsisTeam\ADOL\Entity\Property\Address;
use AsisTeam\ADOL\Entity\Property\Building;
use AsisTeam\ADOL\Entity\Property\Sentence;
use AsisTeam\ADOL\Tests\Cases\Unit\Client\Helpers;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../../../bootstrap.php';

class BuildingClientTest extends TestCase
{

	/**
	 * @throws AsisTeam\ADOL\Exception\ResponseException Response error: "Nejaka chyba"
	 */
	public function testError(): void
	{
		$client = new BuildingClient('token', Helpers::createHttpClientMock('property/any_error.json'));
		$client->getBuilding(0);
	}

	/**
	 * @throws AsisTeam\ADOL\Exception\RequestException
	 */
	public function testFindBuildingInvalidAddressGiven(): void
	{
		$client = new BuildingClient('token', Helpers::createHttpClientMock('property/any_error.json'));
		$client->findBuildings($addr = new Address());
	}

	public function testFindBuildings(): void
	{
		$client = new BuildingClient('token', Helpers::createHttpClientMock('property/building_list.json'));

		$addr = new Address();
		$addr->setRegion('Rokycany');
		$addr->setMunicipality('Mlečice');
		$addr->setMunicipalityPart('Mlečice');
		$addr->setHouseNumber('88');

		$list = $client->findBuildings($addr);
		Assert::count(1, $list);
		Assert::equal(309077408, $list[0]->getId());
	}

	public function testGetBuilding(): void
	{
		$client = new BuildingClient('token', Helpers::createHttpClientMock('property/building_detail.json'));
		$b = $client->getBuilding(309077408);

		Assert::type(Building::class, $b);
		Assert::equal(309077408, $b->getId());
		Assert::equal('Č.P.1', $b->getObjectLabel());
		Assert::equal('budova s číslem popisným', $b->getObjectType());
		Assert::equal(697290, $b->getCadastralAreaCode());
		Assert::equal('Mlečice', $b->getCadastralAreaName());
		Assert::equal('Mlečice', $b->getMunicipality());
		Assert::equal(311, $b->getCertificateOfTitle());

		Assert::equal('Rokycany', $b->getRegion());
		Assert::equal('Mlečice', $b->getMunicipalityPart());
		Assert::equal('objekt k bydlení', $b->getUsage());
		Assert::equal([7125658], $b->getAddressPointCodes());

		Assert::equal(49.919217034446, $b->getGps()->getLat());
		Assert::equal(13.693161559904, $b->getGps()->getLng());
		Assert::equal('building', $b->getGps()->getSource());

		Assert::count(0, $b->getOwnerships());
	}

	public function testGetSentences(): void
	{
		$client = new BuildingClient('token', Helpers::createHttpClientMock('property/building_sentences.json'));
		$s = $client->getSentences(309077408);

		Assert::count(1, $s);
		Assert::type(Sentence::class, $s[0]);

		Assert::equal(309077408, $s[0]->getRealtyId());
		Assert::equal('rozsáhlé chráněné území', $s[0]->getSentence());
		Assert::equal('Způsob ochrany nemovitosti', $s[0]->getType());
		Assert::null($s[0]->getName());
	}

	public function testGetUnits(): void
	{
		$client = new BuildingClient('token', Helpers::createHttpClientMock('property/building_units.json'));
		$units = $client->getUnits(309017408);

		Assert::count(7, $units);
		Assert::equal(309017408, $units[0]->getBuildingId());
		Assert::equal(47189408, $units[0]->getId());
		Assert::equal('88/1', $units[0]->getUnitLabel());
	}

	public function testGetLands(): void
	{
		$client = new BuildingClient('token', Helpers::createHttpClientMock('property/building_lands.json'));
		$units = $client->getLands(309017408);

		Assert::count(1, $units);
		Assert::equal(309017408, $units[0]->getBuildingId());
		Assert::equal(1628009408, $units[0]->getLandId());
		Assert::equal('PKN St. 119', $units[0]->getLandLabel());
	}

	public function testGetOwners(): void
	{
		$client = new BuildingClient('token', Helpers::createHttpClientMock('property/building_owners.json'));
		$owns = $client->getOwnerships(309017408);

		Assert::count(2, $owns);
	}

}

(new BuildingClientTest())->run();
