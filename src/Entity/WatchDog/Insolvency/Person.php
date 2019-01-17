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
		$ins = new self();
		$ins->setPersonalId($personalId);
		$ins->setName($name);
		$ins->setSurname($surname);
		$ins->setDateBirth($dateBirth);
		$ins->setAddress($address);
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
