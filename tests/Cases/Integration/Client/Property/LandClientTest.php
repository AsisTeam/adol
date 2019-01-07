<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Integration\Client\Property;

use AsisTeam\ADOL\Client\Property\LandClient;
use Tester\Assert;

require_once __DIR__ . '/../../../../bootstrap.php';

class LandClientTest extends AbstractPropertyTestCase
{

	/** @var LandClient */
	private $client;

	public function setUp(): void
	{
		parent::setUp();

		$this->client = new LandClient($this->token);
	}

	public function testListLands(): void
	{
		$lands = $this->client->findLands(261, 'Jičín');
		Assert::count(1, $lands, 'Thre should be one land matching given params');
	}

	public function testGetLandDetail(): void
	{
		$land = $this->client->getLand(1753470604);
		Assert::equal(659541, $land->getCadastralAreaCode());
	}

	public function testGetSiteOwners(): void
	{
		$owns = $this->client->getLandOwnerships(1753470604);
		Assert::count(2, $owns, 'Given property should have 2 owners');
	}

	public function testSiteBuildings(): void
	{
		$buildings = $this->client->getLandBuildings(339236231);
		Assert::count(1, $buildings, 'There should be one building placed on the given parcel');
	}

	public function testSiteSentences(): void
	{
		$sentences = $this->client->getLandSentences(1757860604);
		Assert::count(3, $sentences, 'Given land should have 3 sentences associated');
	}

}

(new LandClientTest())->run();
