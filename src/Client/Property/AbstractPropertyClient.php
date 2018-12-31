<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Client\Property;

use AsisTeam\ADOL\Client\AbstractClient;
use AsisTeam\ADOL\Exception\ResponseException;

abstract class AbstractPropertyClient extends AbstractClient
{

	protected const PATH = '/papi/property';

	/**
	 * @param mixed[] $params
	 * @return mixed[]
	 */
	protected function request(string $method, string $url, array $params): array
	{
		$resp = parent::request($method, $url, $params);

		if (!array_key_exists('data', $resp)) {
			throw new ResponseException('Mandatory "data" field missing in response data.');
		}

		return $resp['data'];
	}

}
