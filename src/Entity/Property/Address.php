<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\Property;

final class Address
{

	/** @var string|null */
	private $municipality = '';

	/** @var string|null */
	private $street = '';

	/** @var string|null */
	private $zip = '';

	/** @var string|null */
	private $municipalityPart;

	/** @var string|null */
	private $region;

	/** @var string|null */
	private $houseNumber;

	/** @var string|null */
	private $orientationNumber;

	/** @var string|null */
	private $registrationNumber;

	/**
	 * @param mixed[] $data
	 */
	public static function fromArray(array $data): self
	{
		$addr = new self();
		$addr->setMunicipality($data['obec'] ?? null);
		$addr->setMunicipalityPart($data['castObce'] ?? null);
		$addr->setRegion($data['okres'] ?? null);
		$addr->setStreet($data['ulice'] ?? null);
		$addr->setZip($data['psc'] ?? null);
		$addr->setHouseNumber($data['cisloDomovni'] ?? null);
		$addr->setOrientationNumber($data['cisloOrientacni'] ?? null);
		$addr->setRegistrationNumber($data['cisloEvidencni'] ?? null);

		if (isset($data['budovaCislo'])) {
			$addr->setHouseNumber($data['budovaCislo'] ?? null);
		}

		return $addr;
	}

	public function toString(): string
	{
		$out = $this->street . ' ' . $this->houseNumber;
		$out .= $this->orientationNumber !== null ? '/' . $this->orientationNumber : '';
		$out .= $this->municipalityPart !== null ? ', ' . $this->municipalityPart . ', ' : '';
		$out .= $this->zip . ' ' . $this->municipality;

		return $out;
	}

	public function getMunicipality(): ?string
	{
		return $this->municipality;
	}

	public function setMunicipality(?string $municipality): void
	{
		$this->municipality = $municipality;
	}

	public function getStreet(): ?string
	{
		return $this->street;
	}

	public function setStreet(?string $street): void
	{
		$this->street = $street;
	}

	public function getZip(): ?string
	{
		return $this->zip;
	}

	public function setZip(?string $zip): void
	{
		$this->zip = $zip;
	}

	public function getMunicipalityPart(): ?string
	{
		return $this->municipalityPart;
	}

	public function setMunicipalityPart(?string $municipalityPart): void
	{
		$this->municipalityPart = $municipalityPart;
	}

	public function getRegion(): ?string
	{
		return $this->region;
	}

	public function setRegion(?string $region): void
	{
		$this->region = $region;
	}

	public function getHouseNumber(): ?string
	{
		return $this->houseNumber;
	}

	public function setHouseNumber(?string $houseNumber): void
	{
		$this->houseNumber = $houseNumber;
	}

	public function getOrientationNumber(): ?string
	{
		return $this->orientationNumber;
	}

	public function setOrientationNumber(?string $orientationNumber): void
	{
		$this->orientationNumber = $orientationNumber;
	}

	public function getRegistrationNumber(): ?string
	{
		return $this->registrationNumber;
	}

	public function setRegistrationNumber(?string $registrationNumber): void
	{
		$this->registrationNumber = $registrationNumber;
	}

}
