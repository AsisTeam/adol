<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Unit\Client;

use AsisTeam\ADOL\Client\PropertyWatcher;
use AsisTeam\ADOL\Entity\Estate;
use AsisTeam\ADOL\Entity\Estate\Building;
use AsisTeam\ADOL\Entity\Estate\Land;
use AsisTeam\ADOL\Result\Property\Record;
use GuzzleHttp\Client;
use Mockery;
use Mockery\MockInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../../bootstrap.php';

class PropertyWatcherTest extends TestCase
{

	/**
	 * @throws AsisTeam\ADOL\Exception\ResponseException Response error: "Nejaka chyba"
	 */
	public function testInsertError(): void
	{
		$client = new PropertyWatcher($this->createHttpMock('insert_error.json'), 'token');
		$client->insert(Land::create(549193, Estate::EVIDENCE_PKN, true, 5));
	}

	public function testInsertSuccessWithWarning(): void
	{
		$client = new PropertyWatcher($this->createHttpMock('insert.json'), 'token');
		$ins = $client->insert(Land::create(746118, Estate::EVIDENCE_PKN, true, 5));

		Assert::equal('108193', $ins->getId());

		Assert::true($ins->hasWarning());
		$warn = 'Zadanou nemovitost se aktuálně nepodařilo ověřit. V případě, že nemovitost nebude nalezena na katastru, tak Vás budeme informovat e-mailem.';
		Assert::equal($warn, $ins->getWarning());
	}

	public function testList(): void
	{
		$client = new PropertyWatcher($this->createHttpMock('list.json'), 'token');
		$records = $client->list(0, 10);

		Assert::count(2, $records);

		// first record
		Assert::equal('108193', $records[0]->getId());
		Assert::equal('24.12.2018 10:43', $records[0]->getTimeCreated()->format('j.m.Y H:i'));
		Assert::equal('Parcela 30 v KÚ Blata', $records[0]->getTitle());
		Assert::equal('', $records[0]->getName());
		Assert::equal(1187, $records[0]->getLv());
		Assert::equal('Aktivní', $records[0]->getStatus());
		Assert::count(1, $records[0]->getOwners());
		Assert::equal(' Kuchař Miroslav  Plánická 125, Klatovy V, 33901 Klatovy ', $records[0]->getOwners()[0]);
		Assert::count(0, $records[0]->getProcedures());
		Assert::equal([''], $records[0]->getActiveProcedures());
		Assert::count(0, $records[0]->getShortNotes());
		Assert::equal(Land::TYPE, $records[0]->getEstate()->getEstateType());
		Assert::equal(Estate::EVIDENCE_PKN, $records[0]->getEstate()->getEvidenceType());
		Assert::equal(708437, $records[0]->getEstate()->getCadastralAreaCode());
		Assert::equal(30, $records[0]->getEstate()->getKmenoveCislo());
		Assert::true($records[0]->getEstate()->isBuildingLand());

		// second record - same one is in detail call
		$this->assertRecord($records[1]);
	}

	public function testDetail(): void
	{
		$client = new PropertyWatcher($this->createHttpMock('detail.json'), 'token');
		$record = $client->detail('108216');

		$this->assertRecord($record);
	}

	private function createHttpMock(string $file, int $statusCode = 200): Client
	{
		/** @var StreamInterface|MockInterface $body */
		$body = Mockery::mock('StreamInterface')
			->shouldReceive('getContents')->andReturn(file_get_contents(__DIR__ . '/responses/' . $file))->getMock();

		/** @var ResponseInterface|MockInterface $response */
		$response = Mockery::mock(ResponseInterface::class)
			->shouldReceive('getStatusCode')->andReturn($statusCode)->getMock()
			->shouldReceive('getBody')->andReturn($body)->getMock();

		/** @var Client|MockInterface $client */
		$client = Mockery::mock(Client::class)
			->shouldReceive('request')
			->andReturn($response)
			->once()
			->getMock();

		return $client;
	}

	private function assertRecord(Record $record): void
	{
		Assert::equal('108216', $record->getId());
		Assert::equal('27.12.2018', $record->getTimeCreated()->format('j.m.Y'));
		Assert::equal('Budova č.e.17 v obci Zámostí-Blata  (část Blata)', $record->getTitle());
		Assert::equal('Probíhá ověřování', $record->getStatus());
		Assert::equal(null, $record->getLv());
		Assert::count(0, $record->getOwners());
		Assert::equal('http://abor.adol.cz/adapter/KatastrAdapter.html?typ=budova&id=297028604&hmac=6f0da7cc9c913fcc94ad8672b4b210d487cdbd9f', $record->getCadastralUrl());
		Assert::equal(Building::TYPE, $record->getEstate()->getEstateType());
		Assert::equal(Estate::HOME_NUMBER_HOUSE, $record->getEstate()->getHomeNumberType());
		Assert::equal(17, $record->getEstate()->getHomeNumber());
		Assert::equal(297028604, $record->getEstate()->getEstateId());
		Assert::equal(146064, $record->getEstate()->getVillagePart());
	}

}

(new PropertyWatcherTest())->run();
