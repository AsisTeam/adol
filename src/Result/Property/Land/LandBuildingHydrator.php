<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\Property\Land;

use AsisTeam\ADOL\Entity\Property\Building;
use AsisTeam\ADOL\Result\Property\Building\BuildingDetailHydrator;

final class LandBuildingHydrator
{

	/**
	 * @param mixed[] $data
	 */
	public static function fromArray(array $data): ?Building
	{
		if (
			$data === [] ||
			!array_key_exists('parcelaId', $data) ||
			!array_key_exists('budova', $data) ||
			!is_array($data['budova'])
		) {
			return null;
		}

		return BuildingDetailHydrator::fromArray($data['budova']);
	}

}
