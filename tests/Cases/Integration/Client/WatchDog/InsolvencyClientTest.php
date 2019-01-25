<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Integration\Client\WatchDog;

use AsisTeam\ADOL\Client\WatchDog\InsolvencyClient;
use AsisTeam\ADOL\Entity\WatchDog\Insolvency\Company;
use AsisTeam\ADOL\Entity\WatchDog\Insolvency\Person;
use AsisTeam\ADOL\Tests\Cases\Integration\Client\AbstractTestCase;
use DateTimeImmutable;
use Tester\Assert;

require_once __DIR__ . '/../../../../bootstrap.php';

class InsolvencyClientTest extends AbstractTestCase
{

	/** @var InsolvencyClient */
	private $client;

	public function setUp(): void
	{
		parent::setUp();

		$this->client = new InsolvencyClient($this->token);
	}

	public function testInsertCompany(): void
	{
		$rec = $this->client->insert(Company::create('25581431', 'PSJ INVEST,a.s'));
		Assert::equal('25581431', $rec->getCompanyId());
	}

	public function testInsertPerson(): void
	{
		$rec = $this->client->insert(Person::create('580519/2228'));
		Assert::equal('580519/2228', $rec->getPersonalId());
	}

	public function testDelete(): void
	{
		$this->client->delete('56021');
	}

	public function testList(): void
	{
		$records = $this->client->list(1);
	}

	public function testDetail(): void
	{
		$record = $this->client->detail('56022');
		Assert::equal('56022', $record->getId());
	}

	public function testChanges(): void
	{
		$changes = $this->client->changes(new DateTimeImmutable('2018-10-01'));
	}

}

(new InsolvencyClientTest())->run();
