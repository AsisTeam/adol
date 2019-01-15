<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\Property\Land;

use AsisTeam\ADOL\Entity\Property\Bpej;
use AsisTeam\ADOL\Entity\Property\Gps;
use AsisTeam\ADOL\Entity\Property\Land;
use AsisTeam\ADOL\Result\Property\Common\AbstractDetailHydrator;
use AsisTeam\ADOL\Result\Property\Common\OwnershipListHydrator;
use Throwable;

final class LandDetailHydrator extends AbstractDetailHydrator
{

	/**
	 * @param mixed[] $data
	 */
	public static function fromArray(array $data): Land
	{
		try {
			$land = new Land(
				$data['id'],
				$data['parcelaCislo'],
				$data['typParcely'],
				$data['katUzemiKod'],
				$data['katUzemi'],
				$data['obec'],
				$data['lv'],
				new Gps($data['gpsLat'], $data['gpsLng'], $data['gpsSource']),
				$data['vymera'] ?? 0,
				$data['mapovyList'] ?? '',
				$data['zpUrceniVymery'] ?? '',
				$data['druhPoz'] ?? '',
				new Bpej($data['bpejCelkem'], $data['bpejPrumerNaMetr'], $data['bpejVymera'])
			);

			$land->setOwnerShare($data['podilVlastnika'] ?? '');
			$land->setOwnerships(OwnershipListHydrator::fromArray($data));

			return $land;
		} catch (Throwable $e) {
			self::throwHydrationError($e, $data);
		}
	}

}
