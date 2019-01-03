<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\Property\Land;

use AsisTeam\ADOL\Entity\Property\LandBuildingRelation;
use AsisTeam\ADOL\Exception\ResponseException;

final class LandBuildingRelationHydrator
{

	/**
	 * @param mixed[] $data
	 * @return LandBuildingRelation[]
	 */
	public static function fromArray(array $data): array
	{
		$buildings = [];

		if ($data === []) {
			return $buildings;
		}

		if (!array_key_exists('parcelaId', $data)) {
			throw new ResponseException('Mandatory "parcelaId" field missing in response data.');
		}

		if (!array_key_exists('budova', $data) || !is_array($data['budova'])) {
			throw new ResponseException('Mandatory "budova" field missing in response data.');
		}

		foreach ($data['budova'] as $b) {

			if (!array_key_exists('id', $b) || !array_key_exists('budovaCislo', $b)) {
				throw new ResponseException(sprintf('Missing mandatory fields in response data: %s', json_encode($b)));
			}

			$buildings[] = new LandBuildingRelation($b['id'], $data['parcelaId'], $b['budovaCislo'], '');
		}

		return $buildings;
	}

}
