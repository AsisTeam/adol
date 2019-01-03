<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\Property;

final class LandBuildingRelation
{

	/** @var int */
	private $buildingId;

	/** @var int */
	private $landId;

	/** @var string */
	private $buildingLabel = '';

	/** @var string */
	private $landLabel = '';

	public function __construct(
		int $buildingId,
		int $landId,
		string $buildingLabel,
		string $landLabel
	)
	{
		$this->buildingId    = $buildingId;
		$this->landId        = $landId;
		$this->buildingLabel = $buildingLabel;
		$this->landLabel     = $landLabel;
	}

	public function getBuildingId(): int
	{
		return $this->buildingId;
	}

	public function getLandId(): int
	{
		return $this->landId;
	}

	public function getBuildingLabel(): string
	{
		return $this->buildingLabel;
	}

	public function getLandLabel(): string
	{
		return $this->landLabel;
	}

}
