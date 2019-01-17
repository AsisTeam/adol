<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Integration\Client\WatchDog;

use AsisTeam\ADOL\Client\WatchDog\PropertyClient;
use AsisTeam\ADOL\Entity\WatchDog\Property\Building;
use AsisTeam\ADOL\Entity\WatchDog\Property\Estate;
use AsisTeam\ADOL\Entity\WatchDog\Property\Land;
use AsisTeam\ADOL\Tests\Cases\Integration\Client\AbstractTestCase;
use DateTimeImmutable;
use Tester\Assert;

require_once __DIR__ . '/../../../../bootstrap.php';

class PropertyClientTest extends AbstractTestCase
{

	/** @var PropertyClient */
	private $client;

	public function setUp(): void
	{
		parent::setUp();

		$this->client = new PropertyClient($this->token);
	}

	public function testCrud(): void
	{
		$this->clearAll();

		$records = $this->client->list(0);
		Assert::count(0, $records);

		$insertion = $this->client->insert(Land::create(659541, Estate::EVIDENCE_PKN, true, 5));
		Assert::true((int) $insertion->getId() > 0);

		$record = $this->client->detail($insertion->getId());
		Assert::equal($insertion->getId(), $record->getId());
	}

	/**
	 * @throws AsisTeam\ADOL\Exception\ResponseException Response error: "Kód katastrálního území není platný"
	 */
	public function testInsertError(): void
	{
		$this->client->insert(Land::create(549193, Estate::EVIDENCE_PKN, true, 5));
	}

	public function testInsert(): void
	{
		$this->clearAll();
		$insertion = $this->client->insert(Building::create(146064, Building::HOME_NUMBER_HOUSE, 17));
		Assert::true((int) $insertion->getId() > 0);
	}

	public function testChanges(): void
	{
		$changes = $this->client->changes(new DateTimeImmutable('1980-01-01'));
		Assert::count(0, $changes);
	}

	private function clearAll(): void
	{
		$records = $this->client->list(0);
		foreach ($records as $rec) {
			$this->client->delete($rec->getId());
		}
	}

}

(new PropertyClientTest())->run();
