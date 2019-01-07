<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\Property\BuildingUnit;

use AsisTeam\ADOL\Entity\Property\BuildingUnit;
use AsisTeam\ADOL\Entity\Property\Gps;
use AsisTeam\ADOL\Result\Property\Common\AbstractDetailHydrator;
use AsisTeam\ADOL\Result\Property\Common\OwnershipListHydrator;
use Throwable;

final class BuildingUnitDetailHydrator extends AbstractDetailHydrator
{

	/**
	 * @param mixed[] $data
	 */
	public static function fromArray(array $data): BuildingUnit
	{
		try {
			$unit = new BuildingUnit(
				$data['id'],
				$data['jednotkaCislo'],
				$data['typJednotky'],
				$data['katUzemiKod'],
				$data['katUzemi'],
				$data['obec'],
				$data['lv'],
				new Gps($data['gpsLat'], $data['gpsLng'], $data['gpsSource']),
				$data['okres'],
				$data['castObce'],
				$data['vyuziti'],
				$data['addressPointCodes'],
				$data['podil'],
				$data['budovaId'],
				$data['budovaCislo']
			);

			$unit->setOwnerShare($data['podilVlastnika'] ?? '');
			$unit->setOwnerships(OwnershipListHydrator::fromArray($data));

			return $unit;
		} catch (Throwable $e) {
			self::throwHydrationError($e, $data);
		}
	}

}
