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
		if (!array_key_exists('jendotky', $data)) {
			return [];
		}

		$units = [];
		foreach ($data['jendotky'] as $item) {
			$units[] = BuildingUnitDetailHydrator::fromArray($item);
		}

		return $units;
	}

}
