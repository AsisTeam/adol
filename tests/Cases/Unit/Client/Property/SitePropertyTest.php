<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Unit\Client\Property;

use AsisTeam\ADOL\Client\Property\SiteProperty;
use AsisTeam\ADOL\Entity\Property\Ownership;
use AsisTeam\ADOL\Entity\Property\Site;
use AsisTeam\ADOL\Tests\Cases\Unit\Client\Helpers;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../../../bootstrap.php';

class SitePropertyTest extends TestCase
{

	/**
	 * @throws AsisTeam\ADOL\Exception\ResponseException Response error: "Nejaka chyba"
	 */
	public function testError(): void
	{
		$client = new SiteProperty('token', Helpers::createHttpClientMock('property/any_error.json'));
		$client->getSiteDetail(0);
	}

	public function testListSites(): void
	{
		$client = new SiteProperty('token', Helpers::createHttpClientMock('property/site_list.json'));
		$sites = $client->listSites(15, 'Chodov');

		Assert::count(3, $sites);
		// Site properties to be tested by testGetSiteDetail method
	}

	public function testGetSiteDetail(): void
	{
		$client = new SiteProperty('token', Helpers::createHttpClientMock('property/site_detail.json'));
		$site = $client->getSiteDetail(2207415101);

		Assert::type(Site::class, $site);
		Assert::equal(2207415101, $site->getId());
		Assert::equal('PKN 15/1', $site->getSiteCode());
		Assert::equal('PKN', $site->getSiteType());
		Assert::equal('Praha', $site->getMunicipality());
		Assert::equal(728225, $site->getCadastralAreaCode());
		Assert::equal('Chodov', $site->getCadastralAreaName());
		Assert::equal('Ze souřadnic v S-JTSK', $site->getExcavationType());
		Assert::equal('ostatní plocha', $site->getLandType());
		Assert::equal(567, $site->getLv());
		Assert::equal('DKM', $site->getMapList());
		Assert::null($site->getOwnerShare());

		Assert::count(0, $site->getOwners());

		Assert::equal(30.0, $site->getBpej()->getTotal());
		Assert::equal(20.0, $site->getBpej()->getMeterAverage());
		Assert::equal(10.0, $site->getBpej()->getExcavation());

		Assert::equal(50.033520053805, $site->getGps()->getLat());
		Assert::equal(14.503612442753, $site->getGps()->getLng());
		Assert::equal('land', $site->getGps()->getSource());
	}

	public function testGetSiteOwnership(): void
	{
		$client = new SiteProperty('token', Helpers::createHttpClientMock('property/site_ownership.json'));
		$owns = $client->getSiteOwnerships(2207415101);

		Assert::count(1, $owns);
		$o = $owns[0];

		Assert::type(Ownership::class, $o);
		Assert::equal(2207415101, $o->getSiteId());
		Assert::equal('1/1', $o->getShare());
		Assert::equal('Vlastnické právo', $o->getRightsType());
		Assert::equal('Hai Long Luong', $o->getName());
		Assert::equal('Květnového vítězství 60/13, Chodov, 14900 Praha', $o->getAddress());
	}

	public function testGetSiteBuildings(): void
	{
		$client = new SiteProperty('token', Helpers::createHttpClientMock('property/site_buildings.json'));
		$buildings = $client->getSiteBuildings(1757860604);

		Assert::count(2, $buildings);
		foreach ($buildings as $s) {
			Assert::equal(1757860604, $s->getSiteId());
		}

		Assert::equal(5568585825, $buildings[0]->getId());
		Assert::equal('Č.P.1', $buildings[0]->getLabel());

		Assert::equal(5568585831, $buildings[1]->getId());
		Assert::equal('Č.P.3', $buildings[1]->getLabel());
	}

	public function testGetSiteSentences(): void
	{
		$client = new SiteProperty('token', Helpers::createHttpClientMock('property/site_sentences.json'));
		$sentences = $client->getSiteSentences(1757860604);

		Assert::count(3, $sentences);
		foreach ($sentences as $s) {
			Assert::equal(1757860604, $s->getSiteId());
		}

		Assert::equal('Změna výměr obnovou operátu', $sentences[0]->getSentence());
		Assert::equal('Jiné zápisy', $sentences[0]->getType());
		Assert::null($sentences[0]->getName());

		Assert::equal('nemovitá kulturní památka', $sentences[1]->getSentence());
		Assert::equal('Způsob ochrany nemovitosti', $sentences[1]->getType());
		Assert::null($sentences[1]->getName());

		Assert::equal('pam. rezervace - budova, pozemek v památkové rezervaci', $sentences[2]->getSentence());
		Assert::equal('Způsob ochrany nemovitosti', $sentences[2]->getType());
		Assert::equal('František', $sentences[2]->getName());
	}

}

(new SitePropertyTest())->run();
