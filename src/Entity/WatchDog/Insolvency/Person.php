<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\WatchDog\Insolvency;

use DateTimeImmutable;

final class Person extends Subject implements ISubject
{

	public static function create(
		?string $personalId = null,
		?string $name = null,
		?string $surname = null,
		?DateTimeImmutable $dateBirth = null,
		?string $address = null
	): ISubject
	{
		$p = new self();
		$p->setPersonalId($personalId);
		$p->setName($name);
		$p->setSurname($surname);
		$p->setDateBirth($dateBirth);
		$p->setAddress($address);

		return $p;
	}

	public function isValid(): bool
	{
		if ($this->personalId !== null) {
			return true;
		}

		if ($this->name !== null &&
			$this->surname !== null &&
			$this->dateBirth !== null
		) {
			return true;
		}

		return false;
	}

}
