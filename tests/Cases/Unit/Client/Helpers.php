<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Tests\Cases\Unit\Client;

use GuzzleHttp\ClientInterface;
use Mockery;
use Mockery\MockInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

final class Helpers
{

	public static function createHttpClientMock(string $file, int $statusCode = 200): ClientInterface
	{
		/** @var StreamInterface|MockInterface $body */
		$body = Mockery::mock('StreamInterface')
			->shouldReceive('getContents')->andReturn(file_get_contents(__DIR__ . '/responses/' . $file))->getMock();

		/** @var ResponseInterface|MockInterface $response */
		$response = Mockery::mock(ResponseInterface::class)
			->shouldReceive('getStatusCode')->andReturn($statusCode)->getMock()
			->shouldReceive('getBody')->andReturn($body)->getMock();

		/** @var ClientInterface|MockInterface $client */
		$client = Mockery::mock(ClientInterface::class)
			->shouldReceive('request')
			->andReturn($response)
			->once()
			->getMock();

		return $client;
	}

}
