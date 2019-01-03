<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\Property\Relation;

use AsisTeam\ADOL\Entity\Property\BuildingUnitRelation;
use AsisTeam\ADOL\Exception\ResponseException;

final class BuildingUnitRelationHydrator
{

	/**
	 * @param mixed[] $data
	 * @return BuildingUnitRelation[]
	 */
	public static function fromArray(array $data): array
	{
		$units = [];

		if ($data === []) {
			return $units;
		}

		if (!array_key_exists('budovaId', $data)) {
			throw new ResponseException('Mandatory "budovaId" field missing in response data.');
		}

		if (!array_key_exists('jednotky', $data) || !is_array($data['jednotky'])) {
			throw new ResponseException('Mandatory "jednotky" field missing in response data.');
		}

		foreach ($data['jednotky'] as $u) {

			if (!array_key_exists('id', $u) || !array_key_exists('jednotkaCislo', $u)) {
				throw new ResponseException(sprintf('Missing mandatory fields in response data: %s', json_encode($u)));
			}

			$units[] = new BuildingUnitRelation((int) $u['id'], $u['jednotkaCislo'], (int) $data['budovaId']);
		}

		return $units;
	}

}
