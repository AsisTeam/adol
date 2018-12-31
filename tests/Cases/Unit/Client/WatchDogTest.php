<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Unit\Client;

use AsisTeam\ADOL\Client\WatchDog;
use AsisTeam\ADOL\Entity\WatchDog\Building;
use AsisTeam\ADOL\Entity\WatchDog\Land;
use AsisTeam\ADOL\Entity\WatchDog\Realty;
use AsisTeam\ADOL\Result\WatchDog\Record;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../../bootstrap.php';

class WatchDogTest extends TestCase
{

	/**
	 * @throws AsisTeam\ADOL\Exception\ResponseException Response error: "Nejaka chyba"
	 */
	public function testInsertError(): void
	{
		$client = new WatchDog('token', Helpers::createHttpClientMock('watch-dog/insert_error.json'));
		$client->insert(Land::create(549193, Realty::EVIDENCE_PKN, true, 5));
	}

	public function testInsertSuccessWithWarning(): void
	{
		$client = new WatchDog('token', Helpers::createHttpClientMock('watch-dog/insert.json'));
		$ins = $client->insert(Land::create(746118, Realty::EVIDENCE_PKN, true, 5));

		Assert::equal('108193', $ins->getId());

		Assert::true($ins->hasWarning());
		$warn = 'Zadanou nemovitost se aktuálně nepodařilo ověřit. V případě, že nemovitost nebude nalezena na katastru, tak Vás budeme informovat e-mailem.';
		Assert::equal($warn, $ins->getWarning());
	}

	public function testList(): void
	{
		$client = new WatchDog('token', Helpers::createHttpClientMock('watch-dog/list.json'));
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
		Assert::equal(Realty::EVIDENCE_PKN, $records[0]->getEstate()->getEvidenceType());
		Assert::equal(708437, $records[0]->getEstate()->getCadastralAreaCode());
		Assert::equal(30, $records[0]->getEstate()->getKmenoveCislo());
		Assert::true($records[0]->getEstate()->isBuildingLand());

		// second record - same one is in detail call
		$this->assertRecord108216($records[1]);
	}

	public function testDetail(): void
	{
		$client = new WatchDog('token', Helpers::createHttpClientMock('watch-dog/detail.json'));
		$record = $client->detail('108216');

		$this->assertRecord108216($record);
	}

	private function assertRecord108216(Record $record): void
	{
		Assert::equal('108216', $record->getId());
		Assert::equal('27.12.2018', $record->getTimeCreated()->format('j.m.Y'));
		Assert::equal('Budova č.e.17 v obci Zámostí-Blata  (část Blata)', $record->getTitle());
		Assert::equal('Probíhá ověřování', $record->getStatus());
		Assert::equal(null, $record->getLv());
		Assert::count(0, $record->getOwners());
		Assert::equal('http://abor.adol.cz/adapter/KatastrAdapter.html?typ=budova&id=297028604&hmac=6f0da7cc9c913fcc94ad8672b4b210d487cdbd9f', $record->getCadastralUrl());
		Assert::equal(Building::TYPE, $record->getEstate()->getEstateType());
		Assert::equal(Realty::HOME_NUMBER_HOUSE, $record->getEstate()->getHomeNumberType());
		Assert::equal(17, $record->getEstate()->getHomeNumber());
		Assert::equal(297028604, $record->getEstate()->getEstateId());
		Assert::equal(146064, $record->getEstate()->getVillagePart());
	}

}

(new WatchDogTest())->run();
