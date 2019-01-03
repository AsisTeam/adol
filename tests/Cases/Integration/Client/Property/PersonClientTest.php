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
		Assert::noError(function (): void {
			$p = new Person('Tomáš', 'Sedláček');
			$p->setMunicipality('Jičín');
			$p->setDegreePrefix('Ing.');

			$this->client->findPerson($p);
		});
	}

	public function testGetPerson(): void
	{
		Assert::noError(function (): void {
			$p = new Person('Tomáš', 'Sedláček');
			$p->setMunicipality('Praha');
			$p->setDegreePrefix('Ing.');

			$this->client->getPerson($p);
		});
	}

	public function testGetSites(): void
	{
		Assert::noError(function (): void {
			$this->client->getSites(538364604);
		});
	}

}

(new PersonClientTest())->run();
