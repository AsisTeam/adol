<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\Property\Person;

use AsisTeam\ADOL\Entity\Property\BuildingUnit;
use AsisTeam\ADOL\Result\Property\BuildingUnit\BuildingUnitDetailHydrator;

final class PersonUnitsHydrator
{

	/**
	 * @param mixed[] $data
	 * @return BuildingUnit[]
	 */
	public static function fromArray(array $data): array
	{
		if (!array_key_exists('jednotky', $data) || !is_array($data['jednotky'])) {
			return [];
		}

		$units = [];
		foreach ($data['jednotky'] as $item) {
			$units[] = BuildingUnitDetailHydrator::fromArray($item);
		}

		return $units;
	}

}
