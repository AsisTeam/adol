<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\Property\Land;

use AsisTeam\ADOL\Entity\Property\Land;

final class LandListHydrator
{

	/**
	 * @param mixed[] $data
	 * @return Land[]
	 */
	public static function fromArray(array $data): array
	{
		$lands = [];

		foreach ($data as $item) {
			$lands[] = LandDetailHydrator::fromArray($item);
		}

		return $lands;
	}

}
