<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Unit\Client\WatchDog;

use AsisTeam\ADOL\Client\WatchDog\InsolvencyClient;
use AsisTeam\ADOL\Entity\WatchDog\Insolvency\Company;
use AsisTeam\ADOL\Entity\WatchDog\Insolvency\Person;
use AsisTeam\ADOL\Result\WatchDog\Insolvency\Record;
use AsisTeam\ADOL\Tests\Cases\Unit\Client\Helpers;
use DateTimeImmutable;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../../../bootstrap.php';

class InsolvencyClientTest extends TestCase
{

	/**
	 * @throws AsisTeam\ADOL\Exception\ResponseException Response error: "Službu Hlídač insolvencí nemáte aktivovanou!"
	 */
	public function testError(): void
	{
		$client = new InsolvencyClient('token', Helpers::createHttpClientMock('watch-dog/insolvency/error.json'));
		$client->insert(Company::create('12345678'));
	}

	public function testInsertCompany(): void
	{
		$client = new InsolvencyClient('token', Helpers::createHttpClientMock('watch-dog/insolvency/insert_company.json'));
		$rec = $client->insert(Company::create('25581431'));
		Assert::equal('25581431', $rec->getCompanyId());
		Assert::equal('56003', $rec->getId());
		Assert::equal('PSJ INVEST,a.s', $rec->getName());
		Assert::equal('24.01.2019', $rec->getCreated()->format('j.m.Y'));
	}

	public function testInsertPerson(): void
	{
		$client = new InsolvencyClient('token', Helpers::createHttpClientMock('watch-dog/insolvency/insert_person.json'));
		$rec = $client->insert(Person::create('880412/3466', 'Test', 'Testovic'));
		Assert::equal('880412/3466', $rec->getPersonalId());
		Assert::equal('56021', $rec->getId());
		Assert::equal('Test', $rec->getName());
		Assert::equal('Testovic', $rec->getSurname());
		Assert::equal('25.01.2019', $rec->getCreated()->format('j.m.Y'));
	}

	public function testDelete(): void
	{
		$client = new InsolvencyClient('token', Helpers::createHttpClientMock('watch-dog/insolvency/delete.json'));
		$client->delete('56021');
		Assert::true(true);
	}

	public function testList(): void
	{
		$client = new InsolvencyClient('token', Helpers::createHttpClientMock('watch-dog/insolvency/list.json'));
		$records = $client->list(1);

		Assert::count(3, $records);

		// first record
		$this->assertRecordDetail($records[0]);
		Assert::equal([], $records[0]->getChanges());

		// second record
		Assert::equal('880412/3466', $records[1]->getPersonalId());
		Assert::equal('56021', $records[1]->getId());
		Assert::equal('Test', $records[1]->getName());
		Assert::equal('Testovic', $records[1]->getSurname());
		Assert::equal('25.01.2019', $records[1]->getCreated()->format('j.m.Y'));

		// third record
		Assert::equal('25581431', $records[2]->getCompanyId());
		Assert::equal('56003', $records[2]->getId());
		Assert::equal('PSJ INVEST,a.s', $records[2]->getName());
		Assert::equal('24.01.2019', $records[2]->getCreated()->format('j.m.Y'));
	}

	public function testDetail(): void
	{
		$client = new InsolvencyClient('token', Helpers::createHttpClientMock('watch-dog/insolvency/detail.json'));
		$record = $client->detail('56022');
		$this->assertRecordDetail($record);
		Assert::count(34, $record->getChanges());

		$change = $record->getChanges()[0];
		Assert::equal('KSBR 38 INS 10347 / 2018', $change->getIsir());
		Assert::equal(false, $change->getMerge());
		Assert::equal('A', $change->getPart());
		Assert::equal(1, $change->getOrder());
		Assert::equal(0, $change->getSubOrder());
		Assert::equal('2018-06-21', $change->getCreated()->format('Y-m-d'));
		Assert::equal(34151081, $change->getMainDocId());
		Assert::equal(0, $change->getSubDocId());
		Assert::equal('', $change->getCreditor());
		Assert::equal('Insolvenční návrh spojený s návrhem na povolení oddlužení', $change->getDescription());
		Assert::equal('https://isir.justice.cz/isir/doc/dokument.PDF?id=34151081', $change->getMainDocUrl());
	}

	public function testChanges(): void
	{
		$client = new InsolvencyClient('token', Helpers::createHttpClientMock('watch-dog/insolvency/changes.json'));
		$changes = $client->changes(new DateTimeImmutable('2018-10-01'));

		Assert::count(3, $changes);

		foreach ($changes as $ch) {
			$this->assertRecordDetail($ch->getRecord());
		}

		$ch = $changes[0];
		Assert::equal('KSBR 38 INS 10347 / 2018', $ch->getIsir());
		Assert::equal(false, $ch->getMerge());
		Assert::equal('A', $ch->getPart());
		Assert::equal(1, $ch->getOrder());
		Assert::equal(0, $ch->getSubOrder());
		Assert::equal('2018-06-21', $ch->getCreated()->format('Y-m-d'));
		Assert::equal(34151081, $ch->getMainDocId());
		Assert::equal(0, $ch->getSubDocId());
		Assert::equal('', $ch->getCreditor());
		Assert::equal('Insolvenční návrh spojený s návrhem na povolení oddlužení', $ch->getDescription());
		Assert::equal('https://isir.justice.cz/isir/doc/dokument.PDF?id=34151081', $ch->getMainDocUrl());
	}

	private function assertRecordDetail(Record $rec): void
	{
		// basic info
		Assert::equal('580519/2228', $rec->getPersonalId());
		Assert::equal('56022', $rec->getId());
		Assert::equal('', $rec->getName());
		Assert::equal('', $rec->getSurname());
		Assert::equal('25.01.2019', $rec->getCreated()->format('j.m.Y'));
		Assert::equal(['Jaroslav Vavřička'], $rec->getSubjectNames());
		Assert::equal(['580519/2228'], $rec->getSubjectPersonalIds());
		Assert::equal([], $rec->getSubjectCompanyIds());

		// subject's insolvencies
		Assert::count(2, $rec->getInsolvencies());

		// first insolvency
		$ins = $rec->getInsolvencies()[0];
		Assert::equal('KSBR 38 INS 10347 / 2018', $ins->getIsir());
		Assert::equal('21.06.2018', $ins->getCreated()->format('j.m.Y'));
		Assert::equal('5FE9532E7331497BB27CF36883899AED', $ins->getRowId());
		Assert::equal('Krajský soud v Brně', $ins->getOffice());
		Assert::equal('Prohlášený konkurs', $ins->getStatus());
		Assert::equal([], $ins->getMergeRecords());
		Assert::equal('17.01.2019', $ins->getLastChange()->format('d.m.Y'));

		Assert::count(1, $ins->getSubjects());
		Assert::equal('Jaroslav Vavřička', $ins->getSubjects()[0]->getName());
		Assert::equal('', $ins->getSubjects()[0]->getCompanyId());
		Assert::equal('580519/2228', $ins->getSubjects()[0]->getPersonalId());
		Assert::equal('1958-05-19', $ins->getSubjects()[0]->getDateBirth()->format('Y-m-d'));
		Assert::equal('Zlín, Potoky 4315, PSČ 760 01', $ins->getSubjects()[0]->getAddress());

		Assert::count(1, $ins->getAdministrators());
		Assert::equal('Mgr. Pavla Rojarová', $ins->getAdministrators()[0]->getName());
		Assert::equal(
			'Uherské Hradiště, Zelný trh 1249, PSČ 686 01, Okres Uherské Hradiště',
			$ins->getAdministrators()[0]->getAddress()
		);

		// second insolvency
		$ins = $rec->getInsolvencies()[1];
		Assert::equal('KSBR 40 INS 2928 / 2018', $ins->getIsir());
		Assert::equal('21.02.2018', $ins->getCreated()->format('j.m.Y'));
		Assert::equal('DEA5D10729904E4B85ADE029667C1DE9', $ins->getRowId());
		Assert::equal('Krajský soud v Brně', $ins->getOffice());
		Assert::equal('Pravomocná věc', $ins->getStatus());
		Assert::equal([], $ins->getMergeRecords());
		Assert::equal('19.06.2018', $ins->getLastChange()->format('d.m.Y'));

		Assert::count(1, $ins->getSubjects());
		Assert::equal('Jaroslav Vavřička', $ins->getSubjects()[0]->getName());
		Assert::equal('', $ins->getSubjects()[0]->getCompanyId());
		Assert::equal('580519/2228', $ins->getSubjects()[0]->getPersonalId());
		Assert::equal('1958-05-19', $ins->getSubjects()[0]->getDateBirth()->format('Y-m-d'));
		Assert::equal('Zlín, Potoky 4315, PSČ 760 01', $ins->getSubjects()[0]->getAddress());

		Assert::count(0, $ins->getAdministrators());
	}

}

(new InsolvencyClientTest())->run();
