<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Integration\Client\Property;

use AsisTeam\ADOL\Client\Property\LandClient;
use AsisTeam\ADOL\Entity\Property\Land;
use AsisTeam\ADOL\Entity\Property\LandBuildingRelation;
use AsisTeam\ADOL\Entity\Property\Ownership;
use AsisTeam\ADOL\Entity\Property\Sentence;
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

	public function testListSites(): void
	{
		Assert::noError(function (): void {
			$this->client->listLands(261, 'Jičín');
		});
	}

	public function testGetSiteDetail(): void
	{
		$resp = $this->client->getLandDetail(1753470604);
		Assert::type(Land::class, $resp);
	}

	public function testGetSiteOwners(): void
	{
		$resp = $this->client->getLandOwnerships(1753470604);
		foreach ($resp as $ownership) {
			Assert::type(Ownership::class, $ownership);
		}
	}

	public function testSiteBuildings(): void
	{
		$resp = $this->client->getLandBuildings(1753470604);
		foreach ($resp as $building) {
			Assert::type(LandBuildingRelation::class, $building);
		}
	}

	public function testSiteSentences(): void
	{
		$resp = $this->client->getLandSentences(1757860604);
		foreach ($resp as $sentence) {
			Assert::type(Sentence::class, $sentence);
		}
	}

}

(new LandClientTest())->run();
