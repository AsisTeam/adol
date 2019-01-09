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

	/** @var mixed[]  */
	private $options = [];

	/**
	 * @param mixed[] $requestOptions
	 */
	public function __construct(string $token, ?ClientInterface $client = null, array $requestOptions = [])
	{
		$this->token = $token;
		$this->options = $requestOptions;

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
			$response = $this->client->request($method, $url, array_merge($this->options, $params));
		} catch (Throwable $e) {
			throw new RequestException($e->getMessage(), $e->getCode(), $e);
		}

		if ($response->getStatusCode() !== 200) {
			throw new ResponseException(sprintf('ADOL server returned %d statusCode', $response->getStatusCode()));
		}

//		echo $response->getBody()->getContents(); die();
		$data = json_decode($response->getBody()->getContents(), true);
		if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
			throw new ResponseException(sprintf('Invalid response json given. Error: %s', json_last_error_msg()));
		}

		if (!array_key_exists('status', $data)) {
			throw new ResponseException('Mandatory "status" field missing in response data.');
		}

		if ($data['status'] !== true) {
			$err = $data['errorMessage'] ?? $data['message'] ?? $data['error'] ?? 'Unknown error.';

			throw new ResponseException(sprintf('Response error: "%s"', $err));
		}

		return $data;
	}

}
