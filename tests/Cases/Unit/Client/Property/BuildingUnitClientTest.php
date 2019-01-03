<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Unit\Client\Property;

use AsisTeam\ADOL\Client\Property\BuildingUnitClient;
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

}

(new BuildingUnitClientTest())->run();
