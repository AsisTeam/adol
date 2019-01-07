<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\Property\Land;

use AsisTeam\ADOL\Entity\Property\Ownership;
use AsisTeam\ADOL\Exception\ResponseException;
use AsisTeam\ADOL\Result\Property\Common\OwnershipHydrator;
use Throwable;

final class LandOwnershipHydrator
{

	/**
	 * @param mixed[] $data
	 * @return Ownership[]
	 */
	public static function fromArray(array $data): array
	{
		if (!array_key_exists('vlastnici', $data)) {
			return [];
		}

		$ownerships = [];

		try {
			foreach ($data['vlastnici'] as $ownershipData) {
				$ownerships[] = OwnershipHydrator::fromArray($ownershipData);
			}
		} catch (Throwable $e) {
			throw new ResponseException(sprintf('Could not process response. Error: %s', $e->getMessage()), $e->getCode(), $e);
		}

		return $ownerships;
	}

}
