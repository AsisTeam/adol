<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\Property\Common;

use AsisTeam\ADOL\Entity\Property\Ownership;

final class OwnershipListHydrator
{

	/**
	 * @param mixed[] $data
	 * @return Ownership[]
	 */
	public static function fromArray(array $data): array
	{
		$o = [];
		if (array_key_exists('vlastnici', $data) && $data['vlastnici'] !== null && is_array($data['vlastnici'])) {
			foreach ($data['vlastnici'] as $ownershipData) {
				$o[] = OwnershipHydrator::fromArray($ownershipData);
			}
		}

		return $o;
	}

}
