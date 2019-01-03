<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Integration\Client\Property;

use AsisTeam\ADOL\Client\Property\BuildingUnitClient;
use Tester\Assert;

require_once __DIR__ . '/../../../../bootstrap.php';

class BuildingUnitClientTest extends AbstractPropertyTestCase
{

	/** @var BuildingUnitClient */
	private $client;

	public function setUp(): void
	{
		parent::setUp();

		$this->client = new BuildingUnitClient($this->token);
	}

	public function testGetSentences(): void
	{
		$res = $this->client->getSentences(88606201);

		Assert::true(count($res) > 0);
	}

}

(new BuildingUnitClientTest())->run();
