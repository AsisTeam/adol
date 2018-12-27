<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\Estate;

interface IEstate
{

	public function isValid(): bool;

	/**
	 * @return mixed[]
	 */
	public function toArray(): array;

}
