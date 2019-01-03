<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\Property;

final class Land extends Realty
{

	/** @var int */
	private $acreage; // vymera

	/** @var string */
	private $mapList; // mapovyList

	/** @var string */
	private $measurementType; // zpUrceniVymery

	/** @var string */
	private $landType; // druhPoz

	/** @var Bpej */
	private $bpej; // bonitovaná půdně ekologická jednotka

	/** @var LandBuildingRelation[] */
	private $buildings = [];

	public function __construct(
		int $id,
		string $objectLabel,
		string $objectType,
		int $cadastralAreaCode,
		string $cadastralAreaName,
		string $municipality,
		int $certificateOfTitle,
		Gps $gps,
		int $acreage,
		string $mapList,
		string $measurementType,
		string $landType,
		Bpej $bpej
	)
	{
		parent::__construct(
			$id,
			$objectLabel,
			$objectType,
			$cadastralAreaCode,
			$cadastralAreaName,
			$municipality,
			$certificateOfTitle,
			$gps
		);

		$this->acreage         = $acreage;
		$this->mapList         = $mapList;
		$this->measurementType = $measurementType;
		$this->landType        = $landType;
		$this->bpej            = $bpej;
	}

	public function getAcreage(): int
	{
		return $this->acreage;
	}

	public function getMapList(): string
	{
		return $this->mapList;
	}

	public function getMeasurementType(): string
	{
		return $this->measurementType;
	}

	public function getLandType(): string
	{
		return $this->landType;
	}

	public function getBpej(): Bpej
	{
		return $this->bpej;
	}

	/**
	 * @return LandBuildingRelation[]
	 */
	public function getBuildings(): array
	{
		return $this->buildings;
	}

	/**
	 * @param LandBuildingRelation[] $buildings
	 */
	public function setBuildings(array $buildings): void
	{
		$this->buildings = $buildings;
	}

}
