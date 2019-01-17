<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\WatchDog\Property;

use AsisTeam\ADOL\Exception\InvalidArgumentException;

class Estate implements IEstate
{

	public const VALID_ESTATES = [Land::TYPE, Building::TYPE, BuildingUnit::TYPE];

	public const EVIDENCE_PKN = 'PKN'; // parcela katastru nemovitosti
	public const EVIDENCE_PZE = 'PZE'; // pozemek zjednodusene evidence
	public const VALID_EVIDENCES = [self::EVIDENCE_PKN, self::EVIDENCE_PZE];

	public const SOURCE_GP = 'GP'; // pridelovy plan
	public const SOURCE_EN = 'EN'; // evidence nemovistosti
	public const SOURCE_PK = 'PK'; // pozemkovy katastr
	public const VALID_SOURCES = [self::SOURCE_GP, self::SOURCE_EN, self::SOURCE_PK];

	public const HOME_NUMBER_LAND_REGISTRY = 0; // popisne cislo
	public const HOME_NUMBER_HOUSE = 1; // orientacni cislo
	public const HOME_NUMBER_MISSING = 2; // bez popis. c. i orient. c.
	public const VALID_HOME_NUMBER_TYPES = [self::HOME_NUMBER_LAND_REGISTRY, self::HOME_NUMBER_HOUSE, self::HOME_NUMBER_MISSING];

	/** @var string|null */
	protected $name;

	/** @var string */
	protected $estateType;

	/** @var int|null */
	protected $estateId;

	/** @var int|null */
	protected $cadastralAreaCode;

	/** @var string|null */
	protected $evidenceType;

	/** @var bool|null */
	protected $isBuildingLand;

	/** @var string|null */
	protected $historyCadastralAreaName;

	/** @var int|null */
	protected $kmenoveCislo;

	/** @var int|null */
	protected $poddeleniCislo;

	/** @var int|null */
	protected $dilCislo;

	/** @var string|null */
	protected $historyCadastralAreaCode;

	/** @var string|null */
	protected $source;

	/** @var int|null */
	protected $villagePart;

	/** @var int|null */
	protected $homeNumberType;

	/** @var int|null */
	protected $homeNumber;

	/** @var int|null */
	protected $unit;

	public function __construct(string $estateType)
	{
		if (!in_array($estateType, self::VALID_ESTATES, true)) {
			throw new InvalidArgumentException(sprintf('Invalid estateType "%s" given.', $estateType));
		}

		$this->estateType = $estateType;
	}

	/**
	 * @param mixed[] $a
	 */
	public static function fromArray(array $a): self
	{
		if (!array_key_exists('typeEstate', $a)) {
			throw new InvalidArgumentException('The "typeEstate" key is mandatory for creating Estate fromArray');
		}

		$e = new self($a['typeEstate']);
		$e->name = $a['name'] ?? null;
		$e->estateId = isset($a['estateId']) ? (int) $a['estateId'] : null;
		$e->cadastralAreaCode = isset($a['cadastralAreaCode']) ? (int) $a['cadastralAreaCode'] : null;
		$e->evidenceType = $a['typeEvidence'] ?? null;
		$e->isBuildingLand = isset($a['buildingLand']) ? (bool) $a['buildingLand'] : null;
		$e->kmenoveCislo = isset($a['kmenoveCislo']) ? (int) $a['kmenoveCislo'] : null;
		$e->poddeleniCislo = isset($a['poddeleniCislo']) ? (int) $a['poddeleniCislo'] : null;
		$e->dilCislo = isset($a['dilCislo']) ? (int) $a['dilCislo'] : null;
		$e->historyCadastralAreaName = $a['historyCadastralAreaName'] ?? null;
		$e->source = $a['zdroj'] ?? null;
		$e->villagePart = isset($a['villagePart']) ? (int) $a['villagePart'] : null;
		$e->homeNumberType = isset($a['typeHomeNumber']) ? (int) $a['typeHomeNumber'] : null;
		$e->homeNumber = isset($a['homeNumber']) ? (int) $a['homeNumber'] : null;
		$e->unit = isset($a['unit']) ? (int) $a['unit'] : null;

		return $e;
	}

	public function isValid(): bool
	{
		return true;
	}

	/**
	 * @return mixed[]
	 */
	public function toArray(): array
	{
		$arr = [
			'typeEstate' => $this->estateType,
			'name' => $this->name,
			'estateId' => $this->estateId,
			'cadastralAreaCode' => $this->cadastralAreaCode,
			'typeEvidence' => $this->evidenceType,
			'buildingLand' => $this->isBuildingLand,
			'kmenoveCislo' => $this->kmenoveCislo,
			'poddeleniCislo' => $this->poddeleniCislo,
			'dilCislo' => $this->dilCislo,
			'historyCadastralAreaName' => $this->historyCadastralAreaName,
			'zdroj' => $this->source,
			'villagePart' => $this->villagePart,
			'typeHomeNumber' => $this->homeNumberType,
			'homeNumber' => $this->homeNumber,
			'unit' => $this->unit,
		];

		return array_filter($arr, 'strlen');
	}

	/**
	 * @param mixed[] $fields
	 */
	protected function ensureIsFilled(array $fields): bool
	{
		foreach ($fields as $field) {
			if ($field === null) {
				return false;
			}
		}

		return true;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function setName(?string $name = null): void
	{
		$this->name = $name;
	}

	public function getEstateType(): string
	{
		return $this->estateType;
	}

	public function getEstateId(): ?int
	{
		return $this->estateId;
	}

	public function setEstateId(?int $estateId = null): void
	{
		$this->estateId = $estateId;
	}

	public function getCadastralAreaCode(): ?int
	{
		return $this->cadastralAreaCode;
	}

	public function setCadastralAreaCode(?int $cadastralAreaCode = null): void
	{
		$this->cadastralAreaCode = $cadastralAreaCode;
	}

	public function getEvidenceType(): ?string
	{
		return $this->evidenceType;
	}

	public function setEvidenceType(?string $evidenceType): void
	{
		if ($evidenceType !== null && !in_array($evidenceType, self::VALID_EVIDENCES, true)) {
			throw new InvalidArgumentException(sprintf('Invalid evidenceType "%s" given.', $evidenceType));
		}

		$this->evidenceType = $evidenceType;
	}

	public function isBuildingLand(): ?bool
	{
		return $this->isBuildingLand;
	}

	public function setIsBuildingLand(?bool $isBuildingLand = null): void
	{
		$this->isBuildingLand = $isBuildingLand;
	}

	public function getHistoryCadastralAreaName(): ?string
	{
		return $this->historyCadastralAreaName;
	}

	public function setHistoryCadastralAreaName(?string $historyCadastralAreaName): void
	{
		$this->historyCadastralAreaName = $historyCadastralAreaName;
	}

	public function getKmenoveCislo(): ?int
	{
		return $this->kmenoveCislo;
	}

	public function setKmenoveCislo(?int $kmenoveCislo = null): void
	{
		$this->kmenoveCislo = $kmenoveCislo;
	}

	public function getPoddeleniCislo(): ?int
	{
		return $this->poddeleniCislo;
	}

	public function setPoddeleniCislo(?int $poddeleniCislo = null): void
	{
		$this->poddeleniCislo = $poddeleniCislo;
	}

	public function getDilCislo(): ?int
	{
		return $this->dilCislo;
	}

	public function setDilCislo(?int $dilCislo): void
	{
		$this->dilCislo = $dilCislo;
	}

	public function getHistoryCadastralAreaCode(): ?string
	{
		return $this->historyCadastralAreaCode;
	}

	public function setHistoryCadastralAreaCode(?string $historyCadastralAreaCode = null): void
	{
		$this->historyCadastralAreaCode = $historyCadastralAreaCode;
	}

	public function getSource(): ?string
	{
		return $this->source;
	}

	public function setSource(?string $source = null): void
	{
		$this->source = $source;
	}

	public function getVillagePart(): ?int
	{
		return $this->villagePart;
	}

	public function setVillagePart(?int $villagePart = null): void
	{
		$this->villagePart = $villagePart;
	}

	public function getHomeNumberType(): ?int
	{
		return $this->homeNumberType;
	}

	public function setHomeNumberType(?int $homeNumberType = null): void
	{
		if ($homeNumberType !== null && !in_array($homeNumberType, self::VALID_HOME_NUMBER_TYPES, true)) {
			throw new InvalidArgumentException(sprintf('Invalid homeNumberType "%d" given.', $homeNumberType));
		}

		$this->homeNumberType = $homeNumberType;
	}

	public function getHomeNumber(): ?int
	{
		return $this->homeNumber;
	}

	public function setHomeNumber(?int $homeNumber = null): void
	{
		$this->homeNumber = $homeNumber;
	}

	public function getUnit(): ?int
	{
		return $this->unit;
	}

	public function setUnit(?int $unit = null): void
	{
		$this->unit = $unit;
	}

}
