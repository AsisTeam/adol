<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Integration\Client\Property;

use AsisTeam\ADOL\Client\Property\PersonClient;
use AsisTeam\ADOL\Entity\Property\Person;
use Tester\Assert;

require_once __DIR__ . '/../../../../bootstrap.php';

class PersonClientTest extends AbstractPropertyTestCase
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
		$lands = $this->client->getLands(538364604);
		Assert::count(6, $lands);
	}

}

(new PersonClientTest())->run();
