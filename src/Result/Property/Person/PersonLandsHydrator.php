<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\Property\Person;

use AsisTeam\ADOL\Entity\Property\Land;
use AsisTeam\ADOL\Result\Property\Land\LandDetailHydrator;

final class PersonLandsHydrator
{

	/**
	 * @param mixed[] $data
	 * @return Land[]
	 */
	public static function fromArray(array $data): array
	{
		if (!array_key_exists('parcely', $data)) {
			return [];
		}

		$lands = [];
		foreach ($data['parcely'] as $item) {
			$lands[] = LandDetailHydrator::fromArray($item);
		}

		return $lands;
	}

}
