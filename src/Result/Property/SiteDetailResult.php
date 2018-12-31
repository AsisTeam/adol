<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\Property;

use AsisTeam\ADOL\Entity\Property\Bpej;
use AsisTeam\ADOL\Entity\Property\Gps;
use AsisTeam\ADOL\Entity\Property\Site;
use AsisTeam\ADOL\Exception\ResponseException;

final class SiteDetailResult
{

	/**
	 * @param mixed[] $data
	 */
	public static function fromArray(int $requestedId, array $data): Site
	{
		if (!array_key_exists('id', $data) || $data['id'] !== $requestedId) {
			throw new ResponseException('Returned id does not match requested id.');
		}

		if (
			!array_key_exists('parcelaCislo', $data) ||
			!array_key_exists('obec', $data) ||
			!array_key_exists('katUzemiKod', $data) ||
			!array_key_exists('katUzemi', $data)
		) {
			throw new ResponseException(sprintf('Missing mandatory fields in response data: %s', json_encode($data)));
		}

		$site = new Site(
			$data['id'],
			$data['parcelaCislo'],
			$data['obec'],
			$data['katUzemiKod'],
			$data['katUzemi'],
		);

		$site->setLv($data['lv'] ?? null);
		$site->setAcreage($data['vymera'] ?? null);
		$site->setSiteType($data['typParcely'] ?? null);
		$site->setMapList($data['mapovyList'] ?? null);
		$site->setExcavationType($data['zpUrceniVymery'] ?? null);
		$site->setLandType($data['druhPoz'] ?? null);
		$site->setOwnerShare($data['podilVlastnika'] ?? null);

		if (array_key_exists('gpsLat', $data) && array_key_exists('gpsLng', $data)) {
			$site->setGps(
				new Gps($data['gpsLat'], $data['gpsLng'], $data['gpsSource'] ?? '')
			);
		}

		if (
			array_key_exists('bpejCelkem', $data) &&
			array_key_exists('bpejPrumerNaMetr', $data) &&
			array_key_exists('bpejVymera', $data)
		) {
			$site->setBpej(
				new Bpej($data['bpejCelkem'], $data['bpejPrumerNaMetr'], $data['bpejVymera'])
			);
		}

		if (array_key_exists('vlastnici', $data) && is_array($data['vlastnici'])) {
			foreach ($data['vlastnici'] as $ownershipData) {
				$site->addOwner(SiteOwnershipResult::ownershipFromArray($data['id'], $ownershipData));
			}
		}

		return $site;
	}

}
