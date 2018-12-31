<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\Property;

use AsisTeam\ADOL\Entity\Site\Owner;
use AsisTeam\ADOL\Entity\Site\OwnerAddress;
use AsisTeam\ADOL\Entity\Site\Ownership;
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
	 * @param mixed[] $ownershipData
	 */
	public static function ownershipFromArray(int $requestedId, array $ownershipData): Ownership
	{
		if (!isset($ownershipData['adress'])) {
			throw new ResponseException('Missing owner\'s "jmeno" field in the response');
		}

		if (!isset($ownershipData['jmeno'])) {
			throw new ResponseException('Missing owner\'s "jmeno" field in the response');
		}

		$owner = Owner::fromArray($ownershipData['jmeno']);
		$owner->setAddress(OwnerAddress::fromArray($ownershipData['adress']));

		return new Ownership(
			$requestedId,
			$owner,
			$ownershipData['podil'] ?? '',
			$ownershipData['typPrav'] ?? '',
			$ownershipData['nazev'] ?? '',
		);
	}

}
