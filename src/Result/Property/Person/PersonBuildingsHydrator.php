<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\Property\Person;

use AsisTeam\ADOL\Entity\Property\Building;
use AsisTeam\ADOL\Result\Property\Building\BuildingDetailHydrator;

final class PersonBuildingsHydrator
{

	/**
	 * @param mixed[] $data
	 * @return Building[]
	 */
	public static function fromArray(array $data): array
	{
		if (!array_key_exists('budovy', $data)) {
			return [];
		}

		$buildings = [];
		foreach ($data['budovy'] as $item) {
			$buildings[] = BuildingDetailHydrator::fromArray($item);
		}

		return $buildings;
	}

}
