<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Integration\Client\Property;

use Tester\Environment;
use Tester\TestCase;

abstract class AbstractPropertyTestCase extends TestCase
{

	/** @var string */
	protected $token = 'fill your valid token here';

	public function setUp(): void
	{
		Environment::skip('this test should be run manually (do not forget to fill valid token)');
	}

}
