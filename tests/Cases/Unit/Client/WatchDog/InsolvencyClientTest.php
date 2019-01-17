<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Unit\Client\WatchDog;

use AsisTeam\ADOL\Client\WatchDog\InsolvencyClient;
use AsisTeam\ADOL\Entity\WatchDog\Insolvency\Company;
use AsisTeam\ADOL\Tests\Cases\Unit\Client\Helpers;
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

}

(new InsolvencyClientTest())->run();
