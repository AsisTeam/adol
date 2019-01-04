<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Integration\Client\Property;

use AsisTeam\ADOL\Client\Property\BuildingClient;
use AsisTeam\ADOL\Entity\Property\Address;
use Tester\Assert;

require_once __DIR__ . '/../../../../bootstrap.php';

class BuildingClientTest extends AbstractPropertyTestCase
{

	/** @var BuildingClient */
	private $client;

	public function setUp(): void
	{
		parent::setUp();

		$this->client = new BuildingClient($this->token);
	}

	public function testFindBuildings(): void
	{
		$addr = new Address();
		$addr->setRegion('Jičín');
		$addr->setMunicipality('Jičín');
		$addr->setMunicipalityPart('Holínské Předměstí');
		$addr->setHouseNumber('488');

		$buildings = $this->client->findBuildings($addr);
		Assert::count(1, $buildings);
		Assert::equal(298782604, $buildings[0]->getId());
	}

	public function testGetBuilding(): void
	{
		$building = $this->client->getBuilding(309077408);
		Assert::equal(697290, $building->getCadastralAreaCode());
	}

	public function testGetSentences(): void
	{
		$sentences = $this->client->getSentences(309077408);
		Assert::count(1, $sentences);
		Assert::equal(309077408, $sentences[0]->getRealtyId());
	}

	public function testGetUnits(): void
	{
		$units = $this->client->getUnits(309017408);
		Assert::count(6, $units);
	}

	public function testGetLands(): void
	{
		$lands = $this->client->getLands(309017408);
		Assert::count(1, $lands);
	}

	public function testGetOwners(): void
	{
		$owns = $this->client->getOwnerships(309017408);
		Assert::count(1, $owns);
	}

}

(new BuildingClientTest())->run();
