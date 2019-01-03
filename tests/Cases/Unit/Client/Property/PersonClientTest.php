<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Unit\Client\Property;

use AsisTeam\ADOL\Client\Property\PersonClient;
use AsisTeam\ADOL\Entity\Property\Person;
use AsisTeam\ADOL\Tests\Cases\Unit\Client\Helpers;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../../../bootstrap.php';

class PersonClientTest extends TestCase
{

	/**
	 * @throws AsisTeam\ADOL\Exception\ResponseException Response error: "Nejaka chyba"
	 */
	public function testError(): void
	{
		$client = new PersonClient('token', Helpers::createHttpClientMock('property/any_error.json'));
		$client->findPerson(new Person('', ''));
	}

	public function testFindPerson(): void
	{
		$client = new PersonClient('token', Helpers::createHttpClientMock('property/person_find.json'));
		$persons = $client->findPerson(new Person('Tomáš', 'Sedláček'));

		Assert::count(5, $persons);
		foreach ($persons as $person) {
			Assert::type(Person::class, $person);
		}

		$p = $persons[0];
		Assert::equal(4857134101, $p->getId());
		Assert::equal('V podluží 679/2, Nusle, 14000 Praha', $p->getAddress());
		Assert::equal('Ing. Tomáš Sedláček', $p->getFullName());

		$p = $persons[3];
		Assert::equal(4166779101, $p->getId());
		Assert::equal(4166778101, $p->getFirstPartnerId());
		Assert::equal(1806065209, $p->getSecondPartnerId());
		Assert::equal('Za mlýnem 1563/27, Braník, 14700 Praha', $p->getAddress());
		Assert::equal('Sedláček Tomáš Ing. a Sedláčková Dana Ing.', $p->getFullName());
	}

	public function testGetPerson(): void
	{
		$client = new PersonClient('token', Helpers::createHttpClientMock('property/person_get.json'));
		$persons = $client->getPerson(new Person('Tomáš', 'Sedláček'));

		Assert::count(2, $persons);
		foreach ($persons as $person) {
			Assert::type(Person::class, $person);
		}

		$p = $persons[0];
		Assert::equal(40952368010, $p->getId());
		Assert::equal('Boleslavova 415/42, Nusle, 14000 Praha', $p->getAddress());
		Assert::equal('Ing. Tomáš Sedláček', $p->getFullName());

		$p = $persons[1];
		Assert::equal(4857134101, $p->getId());
		Assert::equal('V podluží 679/2, Nusle, 14000 Praha', $p->getAddress());
		Assert::equal('Ing. Tomáš Sedláček', $p->getFullName());
	}

}

(new PersonClientTest())->run();
