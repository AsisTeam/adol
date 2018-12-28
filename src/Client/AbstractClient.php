<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Client;

use AsisTeam\ADOL\Exception\RequestException;
use AsisTeam\ADOL\Exception\ResponseException;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Throwable;

abstract class AbstractClient
{

	protected const HOST = 'https://app.adol.cz';

	/** @var string */
	private $token;

	/** @var ClientInterface */
	private $client;

	public function __construct(string $token, ?ClientInterface $client = null)
	{
		$this->token = $token;

		if ($client === null) {
			$client = new Client();
		}

		$this->client = $client;
	}

	/**
	 * @param mixed[] $params
	 * @return mixed[]
	 */
	protected function request(string $method, string $url, array $params): array
	{
		if (strpos($url, '?', 1) === false) {
			$url .= '?access_token=' . $this->token;
		} else {
			$url .= '&access_token=' . $this->token;
		}

		try {
			$response = $this->client->request($method, $url, $params);
		} catch (Throwable $e) {
			throw new RequestException($e->getMessage(), $e->getCode(), $e);
		}

		if ($response->getStatusCode() !== 200) {
			throw new ResponseException(sprintf('ADOL server returned %d statusCode', $response->getStatusCode()));
		}

		$data = json_decode($response->getBody()->getContents(), true);
		if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
			throw new ResponseException(sprintf('Invalid response json given. Error: %s', json_last_error_msg()));
		}

		if (!array_key_exists('status', $data)) {
			throw new ResponseException('Mandatory "status" field missing in result data.');
		}

		if ($data['status'] !== true) {
			throw new ResponseException(sprintf('Response error: "%s"', $data['errorMessage'] ?? 'Unknown error.'));
		}

		return $data;
	}

}
