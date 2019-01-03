<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\Property\Relation;

use AsisTeam\ADOL\Entity\Property\LandBuildingRelation;
use AsisTeam\ADOL\Exception\ResponseException;

final class BuildingLandRelationHydrator
{

	/**
	 * @param mixed[] $data
	 * @return LandBuildingRelation[]
	 */
	public static function fromArray(array $data): array
	{
		$rels = [];

		if ($data === []) {
			return $rels;
		}

		if (!array_key_exists('budovaId', $data)) {
			throw new ResponseException('Mandatory "budovaId" field missing in response data.');
		}

		if (!array_key_exists('parcely', $data) || !is_array($data['parcely'])) {
			throw new ResponseException('Mandatory "parcely" field missing in response data.');
		}

		foreach ($data['parcely'] as $land) {

			if (!array_key_exists('id', $land) || !array_key_exists('parcelaCislo', $land)) {
				throw new ResponseException(sprintf('Missing mandatory fields in response data: %s', json_encode($land)));
			}

			$rels[] = new LandBuildingRelation(
				(int) $data['budovaId'],
				(int) $land['id'],
				'',
				(string) $land['parcelaCislo']
			);
		}

		return $rels;
	}

}
