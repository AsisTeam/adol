<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Integration\Client;

use Tester\Environment;
use Tester\TestCase;

abstract class AbstractTestCase extends TestCase
{

	/** @var string */
	protected $token = 'TOKEN';

	public function setUp(): void
	{
		Environment::skip('this test should be run and checked manually (do not forget to fill valid token)');
	}

}
