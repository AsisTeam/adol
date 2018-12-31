<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\Property;

use AsisTeam\ADOL\Entity\Site\Building;
use AsisTeam\ADOL\Exception\ResponseException;

final class SiteBuildingsResult
{

	/**
	 * @param mixed[] $data
	 * @return Building[]
	 */
	public static function fromArray(int $requestedId, array $data): array
	{
		if (!array_key_exists('parcelaId', $data) || $data['parcelaId'] !== $requestedId) {
			throw new ResponseException('Returned parcelaId does not match requested id.');
		}

		if (!array_key_exists('budova', $data) || !is_array($data['budova'])) {
			throw new ResponseException('Mandatory "budova" field missing in response data.');
		}

		$buildings = [];

		foreach ($data['budova'] as $b) {

			if (
				!array_key_exists('id', $b) ||
				!array_key_exists('budovaCislo', $b)
			) {
				throw new ResponseException(sprintf('Missing mandatory fields in response data: %s', json_encode($b)));
			}

			$buildings[] = new Building(
				$b['id'],
				$b['budovaCislo'],
				$requestedId,
			);
		}

		return $buildings;
	}

}
