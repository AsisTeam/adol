<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\Property;

use AsisTeam\ADOL\Entity\Site\Sentence;
use AsisTeam\ADOL\Exception\ResponseException;
use Throwable;

final class SiteSentencesResult
{

	/**
	 * @param mixed[] $data
	 * @return Sentence[]
	 */
	public static function fromArray(int $requestedId, array $data): array
	{
		if (!array_key_exists('id', $data) || $data['id'] !== $requestedId) {
			throw new ResponseException('Returned id does not match requested id.');
		}

		if (!array_key_exists('vety', $data) || !is_array($data['vety'])) {
			throw new ResponseException('Mandatory "vety" field missing in response data.');
		}

		$sentences = [];

		try {
			foreach ($data['vety'] as $s) {
				$sentences[] = new Sentence(
					$requestedId,
					$s['veta'],
					$s['typVety'] ?? null,
					$s['jmeno'] ?? null,
				);
			}

		} catch (Throwable $e) {
			throw new ResponseException(sprintf('Could not process response. Error: %s', $e->getMessage()), $e->getCode(), $e);
		}

		return $sentences;
	}

}
