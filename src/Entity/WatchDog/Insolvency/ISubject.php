<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\WatchDog\Insolvency;

interface ISubject
{

	public function isValid(): bool;

	/**
	 * @return mixed[]
	 */
	public function toArray(): array;

}
