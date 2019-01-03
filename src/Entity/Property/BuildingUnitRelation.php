<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\Property;

final class BuildingUnitRelation
{

	/** @var int */
	private $id;

	/** @var string */
	private $unitLabel;

	/** @var int */
	private $buildingId;

	public function __construct(int $id, string $unitLabel, int $buildingId)
	{
		$this->id         = $id;
		$this->unitLabel  = $unitLabel;
		$this->buildingId = $buildingId;
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getUnitLabel(): string
	{
		return $this->unitLabel;
	}

	public function getBuildingId(): int
	{
		return $this->buildingId;
	}

}
