<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\Property\BuildingUnit;

use AsisTeam\ADOL\Entity\Property\BuildingUnit;

final class BuildingUnitListHydrator
{

	/**
	 * @param mixed[] $data
	 * @return BuildingUnit[]
	 */
	public static function fromArray(array $data): array
	{
		$units = [];

		foreach ($data as $item) {
			$units[] = BuildingUnitDetailHydrator::fromArray($item);
		}

		return $units;
	}

}
