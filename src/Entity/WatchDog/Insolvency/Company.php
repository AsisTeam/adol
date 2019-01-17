<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\WatchDog\Insolvency;

final class Company extends Subject implements ISubject
{

	public static function create(string $companyId, ?string $name = null): ISubject
	{
		$ins = new self();
		$ins->setCompanyId($companyId);
		$ins->setName($name);

		return $ins;
	}

	public function isValid(): bool
	{
		if ($this->companyId !== null) {
			return true;
		}

		return false;
	}

}
