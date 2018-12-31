<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\Property;

final class Site
{

	/** @var int */
	private $id;

	/** @var string */
	private $siteCode;

	/** @var string|null */
	private $siteType;

	/** @var string */
	private $municipality;

	/** @var string */
	private $cadastralAreaName;

	/** @var int */
	private $cadastralAreaCode;

	/** @var int|null */
	private $lv;

	/** @var int|null */
	private $acreage;

	/** @var string|null */
	private $mapList;

	/** @var string|null */
	private $excavationType;

	/** @var string|null */
	private $landType;

	/** @var string|null */
	private $ownerShare;

	/** @var Ownership[] */
	private $owners = [];

	/** @var Building[]  */
	private $buildings = [];

	/** @var Sentence[]  */
	private $sentences = [];

	/** @var Gps|null */
	private $gps;

	/** @var Bpej|null */
	private $bpej;

	public function __construct(
		int $id,
		string $siteCode,
		string $municipality,
		int $cadastralAreaCode,
		string $cadastralAreaName
	)
	{
		$this->id = $id;
		$this->siteCode = $siteCode;
		$this->municipality = $municipality;
		$this->cadastralAreaCode = $cadastralAreaCode;
		$this->cadastralAreaName = $cadastralAreaName;
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function setId(int $id): void
	{
		$this->id = $id;
	}

	public function getSiteCode(): string
	{
		return $this->siteCode;
	}

	public function setSiteCode(string $siteCode): void
	{
		$this->siteCode = $siteCode;
	}

	public function getSiteType(): ?string
	{
		return $this->siteType;
	}

	public function setSiteType(?string $siteType): void
	{
		$this->siteType = $siteType;
	}

	public function getMunicipality(): string
	{
		return $this->municipality;
	}

	public function setMunicipality(string $municipality): void
	{
		$this->municipality = $municipality;
	}

	public function getCadastralAreaName(): string
	{
		return $this->cadastralAreaName;
	}

	public function setCadastralAreaName(string $cadastralAreaName): void
	{
		$this->cadastralAreaName = $cadastralAreaName;
	}

	public function getCadastralAreaCode(): int
	{
		return $this->cadastralAreaCode;
	}

	public function setCadastralAreaCode(int $cadastralAreaCode): void
	{
		$this->cadastralAreaCode = $cadastralAreaCode;
	}

	public function getLv(): ?int
	{
		return $this->lv;
	}

	public function setLv(?int $lv): void
	{
		$this->lv = $lv;
	}

	public function getAcreage(): ?int
	{
		return $this->acreage;
	}

	public function setAcreage(?int $acreage): void
	{
		$this->acreage = $acreage;
	}

	public function getMapList(): ?string
	{
		return $this->mapList;
	}

	public function setMapList(?string $mapList): void
	{
		$this->mapList = $mapList;
	}

	public function getExcavationType(): ?string
	{
		return $this->excavationType;
	}

	public function setExcavationType(?string $excavationType): void
	{
		$this->excavationType = $excavationType;
	}

	public function getLandType(): ?string
	{
		return $this->landType;
	}

	public function setLandType(?string $landType): void
	{
		$this->landType = $landType;
	}

	public function getOwnerShare(): ?string
	{
		return $this->ownerShare;
	}

	public function setOwnerShare(?string $ownerShare): void
	{
		$this->ownerShare = $ownerShare;
	}

	/**
	 * @return Ownership[]
	 */
	public function getOwners(): array
	{
		return $this->owners;
	}

	/**
	 * @param Ownership[] $owners
	 */
	public function setOwners(array $owners): void
	{
		$this->owners = $owners;
	}

	public function addOwner(Ownership $owner): void
	{
		$this->owners[] = $owner;
	}

	public function getGps(): ?Gps
	{
		return $this->gps;
	}

	public function setGps(?Gps $gps): void
	{
		$this->gps = $gps;
	}

	public function getBpej(): ?Bpej
	{
		return $this->bpej;
	}

	public function setBpej(?Bpej $bpej): void
	{
		$this->bpej = $bpej;
	}

	/**
	 * @return Building[]
	 */
	public function getBuildings(): array
	{
		return $this->buildings;
	}

	/**
	 * @param Building[] $buildings
	 */
	public function setBuildings(array $buildings): void
	{
		$this->buildings = $buildings;
	}

	public function addBuilding(Building $building): void
	{
		$this->buildings[] = $building;
	}

	/**
	 * @return Sentence[]
	 */
	public function getSentences(): array
	{
		return $this->sentences;
	}

	/**
	 * @param Sentence[] $sentences
	 */
	public function setSentences(array $sentences): void
	{
		$this->sentences = $sentences;
	}

	public function addSentence(Sentence $sentence): void
	{
		$this->sentences[] = $sentence;
	}

}
