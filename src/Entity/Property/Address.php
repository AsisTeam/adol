<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\Property;

final class Address
{

	/** @var string */
	private $zip = '';

	/** @var string */
	private $municipality = '';

	/** @var string */
	private $street = '';

	/** @var string|null */
	private $municipalityPart;

	/** @var string|null */
	private $houseNumber;

	/** @var string|null */
	private $orientationNumber;

	public function __construct(
		string $zip,
		string $municipality,
		string $street,
		?string $municipalityPart = null,
		?string $houseNumber = null,
		?string $orientationNumber = null
	)
	{
		$this->zip               = $zip;
		$this->municipality      = $municipality;
		$this->street            = $street;
		$this->municipalityPart  = $municipalityPart;
		$this->houseNumber       = $houseNumber;
		$this->orientationNumber = $orientationNumber;
	}

	/**
	 * @param mixed[] $data
	 */
	public static function fromArray(array $data): self
	{
		return new self(
			$data['psc'] ?? '',
			$data['obec'] ?? '',
			$data['ulice'] ?? '',
			$data['castObce'] ?? null,
			$data['cisloDomovni'] ?? null,
			$data['cisloOrientacni'] ?? null,
		);
	}

	public function toString(): string
	{
		$out = $this->street . ' ' . $this->houseNumber;
		$out .= $this->orientationNumber !== null ? '/' . $this->orientationNumber : '';
		$out .= $this->municipalityPart !== null ? ', ' . $this->municipalityPart . ', ' : '';
		$out .= $this->zip . ' ' . $this->municipality;

		return $out;
	}

	public function getZip(): string
	{
		return $this->zip;
	}

	public function getMunicipality(): string
	{
		return $this->municipality;
	}

	public function getStreet(): string
	{
		return $this->street;
	}

	public function getMunicipalityPart(): ?string
	{
		return $this->municipalityPart;
	}

	public function getHouseNumber(): ?string
	{
		return $this->houseNumber;
	}

	public function getOrientationNumber(): ?string
	{
		return $this->orientationNumber;
	}

}
