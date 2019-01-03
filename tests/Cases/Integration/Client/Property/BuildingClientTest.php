<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Integration\Client\Property;

use AsisTeam\ADOL\Client\Property\BuildingClient;
use AsisTeam\ADOL\Entity\Property\Address;
use AsisTeam\ADOL\Entity\Property\Building;
use AsisTeam\ADOL\Entity\Property\Sentence;
use Tester\Assert;
use Tester\Environment;

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

		$res = $this->client->findBuildings($addr);

		Assert::true(count($res) > 0);
		foreach ($res as $building) {
			Assert::type(Building::class, $building);
			Assert::equal(298782604, $building->getId());
		}
	}

	public function testGetBuilding(): void
	{
		$res = $this->client->getBuilding(309077408);
		Assert::type(Building::class, $res);
	}

	public function testGetSentences(): void
	{
		$res = $this->client->getSentences(309077408);

		Assert::true(count($res) > 0);
		foreach ($res as $sentence) {
			Assert::type(Sentence::class, $sentence);
		}
	}

	public function testGetUnits(): void
	{
		Environment::skip('API does not return valid data for getUnits');

		$res = $this->client->getUnits(298782604);
		Assert::true(count($res) > 0);
	}

	public function testGetLands(): void
	{
		Environment::skip('API does not return valid data for getLands');

		$res = $this->client->getLands(309017408);
		Assert::true(count($res) >= 0);
	}

	public function testGetOwners(): void
	{
		$res = $this->client->getOwnerships(309017408);
		Assert::true(count($res) >= 0);
	}

}

(new BuildingClientTest())->run();
