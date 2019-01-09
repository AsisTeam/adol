<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Integration\Client\Property;

use AsisTeam\ADOL\Client\Property\BuildingUnitClient;
use AsisTeam\ADOL\Tests\Cases\Integration\Client\AbstractTestCase;
use Tester\Assert;

require_once __DIR__ . '/../../../../bootstrap.php';

class BuildingUnitClientTest extends AbstractTestCase
{

	/** @var BuildingUnitClient */
	private $client;

	public function setUp(): void
	{
		parent::setUp();

		$this->client = new BuildingUnitClient($this->token);
	}

	public function testFindBuildingUnits(): void
	{
		$units = $this->client->findBuildingUnits('Kladno', 'Slaný', 'Otruby', '35');
		Assert::count(8, $units);
	}

	public function testGetUnit(): void
	{
		$unit = $this->client->getUnit(27193231);
		Assert::equal(3712, $unit->getCertificateOfTitle());
		Assert::equal('byt', $unit->getUsage());
	}

	public function testGetOwnerships(): void
	{
		$owns = $this->client->getOwnerships(88606201);
		Assert::count(1, $owns);
		Assert::equal('1/1', $owns[0]->getShare());
	}

	public function testGetSentences(): void
	{
		$sentences = $this->client->getSentences(88606201);
		Assert::count(4, $sentences);
	}

}

(new BuildingUnitClientTest())->run();
