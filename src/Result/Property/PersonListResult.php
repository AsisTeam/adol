<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\Property;

use AsisTeam\ADOL\Entity\Property\Address;
use AsisTeam\ADOL\Entity\Property\Person;
use AsisTeam\ADOL\Exception\InvalidArgumentException;
use AsisTeam\ADOL\Exception\ResponseException;

final class PersonListResult
{

	/**
	 * @param mixed[] $data
	 * @return Person[]
	 */
	public static function fromArray(array $data): array
	{
		$persons = [];

		foreach ($data as $record) {
			if (!isset($record['id'])) {
				throw new ResponseException(sprintf('Returned person does not have "id" field. Data: %s', json_encode($record)));
			}

			$person = Person::fromArray($record);
			$person->setId((int) $record['id']);
			$person->setFullName(self::extractPersonName($record));
			$person->setAddress(self::extractPersonAddress($record));
			$person->setFirstPartnerId(isset($record['firstPartner']) ? (int) $record['firstPartner'] : null);
			$person->setSecondPartnerId(isset($record['secondPartner']) ? (int) $record['secondPartner'] : null);

			$persons[] = $person;
		}

		return $persons;
	}

	/**
	 * @param mixed[] $data
	 */
	public static function extractPersonAddress(array $data): string
	{
		if (isset($data['adresa'])) {
			return $data['adresa'];
		}

		if (isset($data['adress']) && is_array($data['adress'])) {
			return (Address::fromArray($data['adress']))->toString();
		}

		throw new InvalidArgumentException(sprintf('Could not extract address. Data: %s', json_encode($data)));
	}

	/**
	 * @param mixed[] $data
	 */
	public static function extractPersonName(array $data): string
	{
		if (isset($data['nazev'])) {
			return $data['nazev'];
		}

		if (isset($data['jmeno']) && is_array($data['jmeno'])) {
			return (Person::fromArray($data['jmeno']))->toString();
		}
	}

}
