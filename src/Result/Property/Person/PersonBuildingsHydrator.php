<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\Property\Person;

use AsisTeam\ADOL\Entity\Property\LandBuildingRelation;

final class PersonBuildingsHydrator
{

	/**
	 * @param mixed[] $data
	 * @return LandBuildingRelation[]
	 */
	public static function fromArray(array $data): array
	{
		// TODO - test

		/** @var LandBuildingRelation[] $data */
		return $data;
	}

}
