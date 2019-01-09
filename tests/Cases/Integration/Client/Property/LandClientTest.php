<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Integration\Client\Property;

use AsisTeam\ADOL\Client\Property\LandClient;
use AsisTeam\ADOL\Tests\Cases\Integration\Client\AbstractTestCase;
use Tester\Assert;

require_once __DIR__ . '/../../../../bootstrap.php';

class LandClientTest extends AbstractTestCase
{

	/** @var LandClient */
	private $client;

	public function setUp(): void
	{
		parent::setUp();

		$this->client = new LandClient($this->token);
	}

	public function testFindLands(): void
	{
		$lands = $this->client->findLands(261, 'Jičín');
		Assert::count(1, $lands, 'Thre should be one land matching given params');
	}

	public function testGetLand(): void
	{
		$land = $this->client->getLand(1753470604);
		Assert::equal(659541, $land->getCadastralAreaCode());
	}

	public function testGetOwnerships(): void
	{
		$owns = $this->client->getOwnerships(1753470604);
		Assert::count(2, $owns, 'Given property should have 2 owners');
	}

	public function testGetBuilding(): void
	{
		$building = $this->client->getBuilding(339236231);
		Assert::equal(60355231, $building->getId());
	}

	public function testGetSentences(): void
	{
		$sentences = $this->client->getSentences(1757860604);
		Assert::count(3, $sentences, 'Given land should have 3 sentences associated');
	}

}

(new LandClientTest())->run();
