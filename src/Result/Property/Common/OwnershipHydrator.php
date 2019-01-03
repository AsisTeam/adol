<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\Property\Common;

use AsisTeam\ADOL\Entity\Property\Ownership;
use AsisTeam\ADOL\Exception\InvalidArgumentException;
use AsisTeam\ADOL\Exception\ResponseException;
use AsisTeam\ADOL\Result\Property\Person\PersonListHydrator;

final class OwnershipHydrator
{

	/**
	 * @param mixed[] $data
	 */
	public static function fromArray(array $data): Ownership
	{
		try {
			$address = PersonListHydrator::extractPersonAddress($data);
			$name = PersonListHydrator::extractPersonName($data);

			return new Ownership(
				$name,
				$address,
				$data['podil'] ?? '',
				$data['typPrav'] ?? '',
			);
		} catch (InvalidArgumentException $e) {
			throw new ResponseException($e->getMessage(), $e->getCode(), $e);
		}
	}

}
