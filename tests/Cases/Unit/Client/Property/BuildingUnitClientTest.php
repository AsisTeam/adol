<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Unit\Client\Property;

use AsisTeam\ADOL\Client\Property\BuildingUnitClient;
use AsisTeam\ADOL\Entity\Property\BuildingUnit;
use AsisTeam\ADOL\Entity\Property\Ownership;
use AsisTeam\ADOL\Entity\Property\Sentence;
use AsisTeam\ADOL\Tests\Cases\Unit\Client\Helpers;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../../../bootstrap.php';

class BuildingUnitClientTest extends TestCase
{

	/**
	 * @throws AsisTeam\ADOL\Exception\ResponseException Response error: "Nejaka chyba"
	 */
	public function testError(): void
	{
		$client = new BuildingUnitClient('token', Helpers::createHttpClientMock('property/any_error.json'));
		$client->getSentences(0);
	}

	public function testFindUnits(): void
	{
		$client = new BuildingUnitClient('token', Helpers::createHttpClientMock('property/unit_list.json'));
		$units = $client->findBuildingUnits('Kladno', 'Slaný', 'Otruby', '35');

		Assert::count(8, $units);

		Assert::equal('34/1', $units[0]->getObjectLabel());
		Assert::equal('590/4720', $units[0]->getPortion());

		Assert::equal('35/8', $units[7]->getObjectLabel());
		Assert::equal('590/4720', $units[7]->getPortion());
	}

	public function testGetUnit(): void
	{
		$client = new BuildingUnitClient('token', Helpers::createHttpClientMock('property/unit_detail.json'));
		$unit = $client->getUnit(88606201);

		Assert::type(BuildingUnit::class, $unit);
		Assert::equal('192/4', $unit->getObjectLabel());
		Assert::equal('jednotka vymezená podle zákona o vlastnictví bytů', $unit->getObjectType());
		Assert::equal('byt', $unit->getUsage());
	}

	public function testGetSentences(): void
	{
		$client = new BuildingUnitClient('token', Helpers::createHttpClientMock('property/unit_sentences.json'));
		$sentences = $client->getSentences(88606201);

		Assert::count(4, $sentences);
		foreach ($sentences as $s) {
			Assert::type(Sentence::class, $s);
			Assert::equal(88606201, $s->getRealtyId());
			Assert::equal('Omezení vlastnického práva', $s->getType());
			Assert::null($s->getName());
		}

		Assert::equal('Věcné břemeno chůze a jízdy', $sentences[0]->getSentence());
		Assert::equal('Věcné břemeno oprav a údržby', $sentences[1]->getSentence());
		Assert::equal('Věcné břemeno (podle listiny)', $sentences[2]->getSentence());
		Assert::equal('Zástavní právo smluvní', $sentences[3]->getSentence());
	}

	public function testGetOwnerships(): void
	{
		$client = new BuildingUnitClient('token', Helpers::createHttpClientMock('property/unit_ownership.json'));
		$owns = $client->getOwnerships(88606201);

		Assert::count(1, $owns);
		Assert::type(Ownership::class, $owns[0]);
		Assert::equal('Pod Chrastišovem 189, Jankov, 25703 Jankov', $owns[0]->getAddress());
		Assert::equal('Ondřej Kunc', $owns[0]->getName());
		Assert::equal('Vlastnické právo', $owns[0]->getRightsType());
		Assert::equal('1/1', $owns[0]->getShare());
	}

}

(new BuildingUnitClientTest())->run();
