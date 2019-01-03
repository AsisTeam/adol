<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Integration\Client;

use AsisTeam\ADOL\Client\WatchDogClient;
use AsisTeam\ADOL\Entity\WatchDog\Building;
use AsisTeam\ADOL\Entity\WatchDog\Land;
use Tester\Assert;
use Tester\Environment;
use Tester\TestCase;

require_once __DIR__ . '/../../../bootstrap.php';

class WatchDogClientTest extends TestCase
{

	/** @var WatchDogClient */
	private $client;

	public function setUp(): void
	{
		$this->client = new WatchDogClient('fill your token here');
		Environment::skip('this test should be run manually (do not forget to fill valid token)');
	}

	public function testCrud(): void
	{
		$this->clear();

		$records = $this->client->list(0);
		Assert::count(0, $records);

		$insertion = $this->client->insert(Land::create(549193, Realty::EVIDENCE_PKN, true, 5));
		Assert::true((int) $insertion->getId() > 0);

		$record = $this->client->detail($insertion->getId());
		Assert::equal($insertion->getId(), $record->getId());
	}

	/**
	 * @throws AsisTeam\ADOL\Exception\ResponseException Response error: "Kód katastrálního území není platný"
	 */
	public function testInsertError(): void
	{
		$this->client->insert(Land::create(549193, Realty::EVIDENCE_PKN, true, 5));
	}

	public function testInsert(): void
	{
		$this->clearAll();
		$insertion = $this->client->insert(Building::create(146064, Building::HOME_NUMBER_HOUSE, 17));
		Assert::true((int) $insertion->getId() > 0);
	}

	private function clearAll(): void
	{
		$records = $this->client->list(0);
		foreach ($records as $rec) {
			$this->client->delete($rec->getId());
		}
	}

}

(new WatchDogClientTest())->run();
