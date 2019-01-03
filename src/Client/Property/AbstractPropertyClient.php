<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Client\Property;

use AsisTeam\ADOL\Client\AbstractClient;
use AsisTeam\ADOL\Entity\Property\Sentence;
use AsisTeam\ADOL\Exception\ResponseException;
use AsisTeam\ADOL\Result\Property\Common\SentencesHydrator;

abstract class AbstractPropertyClient extends AbstractClient
{

	protected const PATH = '/papi/property';

	/**
	 * @return Sentence[]
	 */
	protected function callGetSentences(string $action, int $id): array
	{
		$data = $this->request('GET', sprintf($this->getHost() . $action, $id));

		return SentencesHydrator::fromArray($id, $data);
	}

	/**
	 * @param mixed[] $params
	 * @return mixed[]
	 */
	protected function request(string $method, string $url, array $params = []): array
	{
		$resp = parent::request($method, $url, $params);

		if (!array_key_exists('data', $resp)) {
			throw new ResponseException('Mandatory "data" field missing in response data.');
		}

		return $resp['data'];
	}

	protected function getHost(): string
	{
		return self::HOST . self::PATH;
	}

	/**
	 * @param mixed[] $fields
	 */
	protected function createQuery(array $fields): string
	{
		$clean = array_filter($fields, 'strlen');

		return http_build_query($clean);
	}

}
