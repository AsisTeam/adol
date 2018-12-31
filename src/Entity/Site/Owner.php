<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\Site;

final class Owner
{

	/** @var string */
	private $firstName;

	/** @var string */
	private $lastName;

	/** @var string|null */
	private $degreePrefix;

	/** @var string|null */
	private $degreeSuffix;

	/** @var OwnerAddress|null */
	private $address;

	public function __construct(
		string $firstName,
		string $lastName,
		?string $degreePrefix = null,
		?string $degreeSuffix = null,
		?OwnerAddress $address = null
	)
	{
		$this->firstName    = $firstName;
		$this->lastName     = $lastName;
		$this->degreePrefix = $degreePrefix;
		$this->degreeSuffix = $degreeSuffix;
		$this->address      = $address;
	}

	/**
	 * @param mixed[] $data
	 */
	public static function fromArray(array $data): self
	{
		return new self(
			$data['krestniJmeno'] ?? '',
			$data['prijmeni'] ?? '',
			$data['titulPred'] ?? null,
			$data['titulZa'] ?? null,
		);
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

	public function getDegreeSuffix(): ?string
	{
		return $this->degreeSuffix;
	}

	public function setAddress(?OwnerAddress $address): void
	{
		$this->address = $address;
	}

	public function getAddress(): ?OwnerAddress
	{
		return $this->address;
	}

}
