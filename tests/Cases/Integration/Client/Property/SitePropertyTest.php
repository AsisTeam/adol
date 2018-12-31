<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Integration\Client\Property;

use AsisTeam\ADOL\Client\Property\SiteProperty;
use AsisTeam\ADOL\Entity\Property\Building;
use AsisTeam\ADOL\Entity\Property\Ownership;
use AsisTeam\ADOL\Entity\Property\Sentence;
use AsisTeam\ADOL\Entity\Property\Site;
use Tester\Assert;

require_once __DIR__ . '/../../../../bootstrap.php';

class SitePropertyTest extends AbstractPropertyTestCase
{

	/** @var SiteProperty */
	private $client;

	public function setUp(): void
	{
		parent::setUp();

		$this->client = new SiteProperty($this->token);
	}

	public function testListSites(): void
	{
		Assert::noError(function (): void {
			$this->client->listSites(261, 'Jičín');
		});
	}

	public function testGetSiteDetail(): void
	{
		$resp = $this->client->getSiteDetail(1753470604);
		Assert::type(Site::class, $resp);
	}

	public function testGetSiteOwners(): void
	{
		$resp = $this->client->getSiteOwnerships(1753470604);
		foreach ($resp as $ownership) {
			Assert::type(Ownership::class, $ownership);
		}
	}

	public function testSiteBuildings(): void
	{
		$resp = $this->client->getSiteBuildings(1753470604);
		foreach ($resp as $building) {
			Assert::type(Building::class, $building);
		}
	}

	public function testSiteSentences(): void
	{
		$resp = $this->client->getSiteSentences(1757860604);
		foreach ($resp as $sentence) {
			Assert::type(Sentence::class, $sentence);
		}
	}

}

(new SitePropertyTest())->run();
