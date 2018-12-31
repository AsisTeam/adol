<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\Property;

final class Person
{

	/** @var string */
	private $firstName;

	/** @var string */
	private $lastName;

	/** @var string|null */
	private $degreePrefix;

	/** @var string|null */
	private $degreeSuffix;

	/** @var string|null */
	private $municipality;

	/** @var string|null */
	private $region;

	/** @var string|null */
	private $personalId;

	/** @var int|null */
	private $dayOfBirth;

	/** @var int|null */
	private $monthOfBirth;

	/** @var int|null */
	private $yearOfBirth;

	/** @var string|null */
	private $companyId;

	/** @var string|null */
	private $companyName;

	/** @var int|null */
	private $id;

	/** @var int|null */
	private $firstPartnerId;

	/** @var int|null */
	private $secondPartnerId;

	/** @var string|null */
	private $address;

	/** @var  string|null */
	private $fullName;

	public function __construct(string $firstName, string $lastName)
	{
		$this->firstName = $firstName;
		$this->lastName = $lastName;
	}

	/**
	 * @param mixed[] $data
	 */
	public static function fromArray(array $data): self
	{
		$owner = new self(
			$data['krestniJmeno'] ?? '',
			$data['prijmeni'] ?? ''
		);

		$owner->setDegreePrefix($data['titulPred'] ?? null);
		$owner->setDegreeSuffix($data['titulZa'] ?? null);

		return $owner;
	}

	public function toString(): string
	{
		$out = $this->firstName . ' ' . $this->lastName;

		if ($this->degreePrefix !== null) {
			$out = $this->degreePrefix . ' ' . $out;
		}

		if ($this->degreeSuffix !== null) {
			$out .= ' ' . $this->getDegreeSuffix();
		}

		return $out;
	}

	public function getFirstName(): string
	{
		return $this->firstName;
	}

	public function getLastName(): string
	{
		return $this->lastName;
	}

	public function getDegreePrefix(): ?string
	{
		return $this->degreePrefix;
	}

	public function setDegreePrefix(?string $degreePrefix): void
	{
		$this->degreePrefix = $degreePrefix;
	}

	public function getDegreeSuffix(): ?string
	{
		return $this->degreeSuffix;
	}

	public function setDegreeSuffix(?string $degreeSuffix): void
	{
		$this->degreeSuffix = $degreeSuffix;
	}

	public function getMunicipality(): ?string
	{
		return $this->municipality;
	}

	public function setMunicipality(?string $municipality): void
	{
		$this->municipality = $municipality;
	}

	public function getRegion(): ?string
	{
		return $this->region;
	}

	public function setRegion(?string $region): void
	{
		$this->region = $region;
	}

	public function getPersonalId(): ?string
	{
		return $this->personalId;
	}

	public function setPersonalId(?string $personalId): void
	{
		$this->personalId = $personalId;
	}

	public function getDayOfBirth(): ?int
	{
		return $this->dayOfBirth;
	}

	public function setDayOfBirth(?int $dayOfBirth): void
	{
		$this->dayOfBirth = $dayOfBirth;
	}

	public function getMonthOfBirth(): ?int
	{
		return $this->monthOfBirth;
	}

	public function setMonthOfBirth(?int $monthOfBirth): void
	{
		$this->monthOfBirth = $monthOfBirth;
	}

	public function getYearOfBirth(): ?int
	{
		return $this->yearOfBirth;
	}

	public function setYearOfBirth(?int $yearOfBirth): void
	{
		$this->yearOfBirth = $yearOfBirth;
	}

	public function getCompanyId(): ?string
	{
		return $this->companyId;
	}

	public function setCompanyId(?string $companyId): void
	{
		$this->companyId = $companyId;
	}

	public function getCompanyName(): ?string
	{
		return $this->companyName;
	}

	public function setCompanyName(?string $companyName): void
	{
		$this->companyName = $companyName;
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function setId(?int $id): void
	{
		$this->id = $id;
	}

	public function getFirstPartnerId(): ?int
	{
		return $this->firstPartnerId;
	}

	public function setFirstPartnerId(?int $firstPartnerId): void
	{
		$this->firstPartnerId = $firstPartnerId;
	}

	public function getSecondPartnerId(): ?int
	{
		return $this->secondPartnerId;
	}

	public function setSecondPartnerId(?int $secondPartnerId): void
	{
		$this->secondPartnerId = $secondPartnerId;
	}

	public function getAddress(): ?string
	{
		return $this->address;
	}

	public function setAddress(?string $address): void
	{
		$this->address = $address;
	}

	public function getFullName(): ?string
	{
		return $this->fullName;
	}

	public function setFullName(?string $fullName): void
	{
		$this->fullName = $fullName;
	}

}
