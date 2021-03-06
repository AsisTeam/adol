<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Integration\Client\Property;

use AsisTeam\ADOL\Client\Property\PersonClient;
use AsisTeam\ADOL\Entity\Property\Person;
use AsisTeam\ADOL\Tests\Cases\Integration\Client\AbstractTestCase;
use Tester\Assert;

require_once __DIR__ . '/../../../../bootstrap.php';

class PersonClientTest extends AbstractTestCase
{

	/** @var PersonClient */
	private $client;

	public function setUp(): void
	{
		parent::setUp();

		$this->client = new PersonClient($this->token);
	}

	public function testFindPerson(): void
	{
		$p = new Person('Tomáš', 'Sedláček');
		$p->setMunicipality('Praha');
		$p->setDegreePrefix('Ing.');

		$persons = $this->client->findPerson($p);
		Assert::count(5, $persons);
	}

	public function testGetPerson(): void
	{
		$p = new Person('Tomáš', 'Sedláček');
		$p->setMunicipality('Praha');
		$p->setDegreePrefix('Ing.');

		$persons = $this->client->getPerson($p);
		Assert::count(2, $persons);
	}

	public function testGetLands(): void
	{
		$lands = $this->client->getLands(1002776708);
		Assert::count(111, $lands);
	}

	public function testGetBuildings(): void
	{
		$buildings = $this->client->getBuildings(538364604);
		Assert::count(3, $buildings);
	}

	public function testGetBuildingUnits(): void
	{
		$units = $this->client->getUnits(438344502);
		Assert::count(1, $units);
	}

}

(new PersonClientTest())->run();
