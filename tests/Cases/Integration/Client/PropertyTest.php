<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Integration\Client;

use AsisTeam\ADOL\Client\Property;
use AsisTeam\ADOL\Entity\Site\Building;
use AsisTeam\ADOL\Entity\Site\Sentence;
use AsisTeam\ADOL\Entity\Site\Site;
use Tester\Assert;
use Tester\Environment;
use Tester\TestCase;

require_once __DIR__ . '/../../../bootstrap.php';

class PropertyTest extends TestCase
{

	/** @var Property */
	private $client;

	public function setUp(): void
	{
		$this->client = new Property('fill your token here');
		Environment::skip('this test should be run manually (do not forget to fill valid token)');
	}

	public function testListSites(): void
	{
		Assert::noError(function (): void {
			$this->client->listSites(35, 'Jičín');
		});
	}

	public function testSiteBuildings(): void
	{
		$resp = $this->client->getSiteBuildings(1757860604);
		Assert::type(Building::class, $resp);
	}

	public function testSiteSentences(): void
	{
		$resp = $this->client->getSiteSentences(1757860604);
		Assert::type(Sentence::class, $resp);
	}

	public function testGetSiteDetail(): void
	{
		$resp = $this->client->getSiteDetail(1757880604);
		Assert::type(Site::class, $resp);
	}

	public function testGetSiteOwners(): void
	{
		$owns = $this->client->getSiteOwnerships(2207415101);
		Assert::count(1, $owns);

		$o = $owns[0];
		Assert::equal(2207415101, $o->getSiteId());
		Assert::equal('1/1', $o->getShare());
		Assert::equal('Vlastnické právo', $o->getRightsType());
		Assert::equal('Hai Long Luong', $o->getOwner()->toString());
		Assert::equal('Květnového vítězství 60/13, Chodov, 14900 Praha', $o->getOwner()->getAddress()->toString());
	}

}

(new PropertyTest())->run();
