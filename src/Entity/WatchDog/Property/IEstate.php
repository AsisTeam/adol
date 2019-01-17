<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\WatchDog\Property;

interface IEstate
{

	public function isValid(): bool;

	/**
	 * @return mixed[]
	 */
	public function toArray(): array;

}
