<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Integration\Client\WatchDog;

use AsisTeam\ADOL\Client\WatchDog\InsolvencyClient;
use AsisTeam\ADOL\Entity\WatchDog\Insolvency\Company;
use AsisTeam\ADOL\Tests\Cases\Integration\Client\AbstractTestCase;
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

	public function testInsert(): void
	{
		$insertion = $this->client->insert(Company::create('25581431', 'PSJ INVEST,a.s'));
		Assert::true((int) $insertion->getId() > 0);
	}

}

(new InsolvencyClientTest())->run();
