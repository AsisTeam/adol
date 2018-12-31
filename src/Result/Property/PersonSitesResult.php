<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\Property;

use AsisTeam\ADOL\Entity\Property\Site;

final class PersonSitesResult
{

	/**
	 * @param mixed[] $data
	 * @return Site[]
	 */
	public static function fromArray(array $data): array
	{
		/** @var Site[] $data */
		return $data;
	}

}
