<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\Property;

use AsisTeam\ADOL\Entity\Property\Ownership;
use AsisTeam\ADOL\Exception\InvalidArgumentException;
use AsisTeam\ADOL\Exception\ResponseException;
use Throwable;

final class SiteOwnershipResult
{

	/**
	 * @param mixed[] $data
	 * @return Ownership[]
	 */
	public static function fromArray(int $requestedId, array $data): array
	{
		if (!array_key_exists('id', $data) || $data['id'] !== $requestedId) {
			throw new ResponseException('Returned id does not match requested id.');
		}

		if (!array_key_exists('vlastnici', $data)) {
			throw new ResponseException('Mandatory "vlastnici" field missing in response data.');
		}

		$ownerships = [];

		try {
			foreach ($data['vlastnici'] as $ownershipData) {
				$ownerships[] = self::ownershipFromArray($requestedId, $ownershipData);
			}
		} catch (Throwable $e) {
			throw new ResponseException(sprintf('Could not process response. Error: %s', $e->getMessage()), $e->getCode(), $e);
		}

		return $ownerships;
	}

	/**
	 * @param mixed[] $data
	 */
	public static function ownershipFromArray(int $requestedId, array $data): Ownership
	{
		try {
			$address = PersonListResult::extractPersonAddress($data);
			$name = PersonListResult::extractPersonName($data);

			return new Ownership(
				$requestedId,
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
