<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\Property\Building;

use AsisTeam\ADOL\Entity\Property\Building;
use AsisTeam\ADOL\Entity\Property\Gps;
use AsisTeam\ADOL\Result\Property\Common\AbstractDetailHydrator;
use AsisTeam\ADOL\Result\Property\Common\OwnershipListHydrator;
use Throwable;

final class BuildingDetailHydrator extends AbstractDetailHydrator
{

	/**
	 * @param mixed[] $data
	 */
	public static function fromArray(array $data): Building
	{
		try {
			$building = new Building(
				$data['id'],
				$data['budovaCislo'],
				$data['typStavby'],
				$data['katUzemiKod'],
				$data['katUzemi'],
				$data['obec'],
				$data['lv'],
				new Gps($data['gpsLat'], $data['gpsLng'], $data['gpsSource']),
				$data['okres'],
				$data['castObce'],
				$data['zpVyuziti'],
				$data['addressPointCodes'],
			);

			$building->setOwnerships(OwnershipListHydrator::fromArray($data));

			return $building;
		} catch (Throwable $e) {
			self::throwHydrationError($e, $data);
		}
	}

}
