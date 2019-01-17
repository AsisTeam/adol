<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\WatchDog\Insolvency;

use DateTimeImmutable;

class Subject
{

	/** @var DateTimeImmutable|null */
	protected $dateBirth;

	/** @var string|null */
	protected $personalId;

	/** @var string|null */
	protected $name;

	/** @var string|null */
	protected $surname;

	/** @var string|null */
	protected $address;

	/** @var string|null */
	protected $companyId;

	/**
	 * @return mixed[]
	 */
	public function toArray(): array
	{
		$arr = [
			'ic'        => $this->companyId,
			'rc'        => $this->personalId,
			'dateBirth' => $this->dateBirth !== null ? $this->dateBirth->format('Y-m-d') : null,
			'name'      => $this->name,
			'surname'   => $this->surname,
			'address'   => $this->address,
		];

		return array_filter($arr, 'strlen');
	}

	public function getDateBirth(): ?DateTimeImmutable
	{
		return $this->dateBirth;
	}

	public function setDateBirth(?DateTimeImmutable $dateBirth): void
	{
		$this->dateBirth = $dateBirth;
	}

	public function getPersonalId(): ?string
	{
		return $this->personalId;
	}

	public function setPersonalId(?string $personalId): void
	{
		$this->personalId = $personalId;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function setName(?string $name): void
	{
		$this->name = $name;
	}

	public function getSurname(): ?string
	{
		return $this->surname;
	}

	public function setSurname(?string $surname): void
	{
		$this->surname = $surname;
	}

	public function getAddress(): ?string
	{
		return $this->address;
	}

	public function setAddress(?string $address): void
	{
		$this->address = $address;
	}

	public function getCompanyId(): ?string
	{
		return $this->companyId;
	}

	public function setCompanyId(?string $companyId): void
	{
		$this->companyId = $companyId;
	}

}
