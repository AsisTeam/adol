<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\Property;

final class BuildingUnit extends Building
{

	/** @var string */
	private $portion;

	/** @var int */
	private $buildingId;

	/** @var string */
	private $buildingLabel;

	/**
	 * @param int[] $addressPointCodes
	 */
	public function __construct(
		int $id,
		string $objectLabel,
		string $objectType,
		int $cadastralAreaCode,
		string $cadastralAreaName,
		string $municipality,
		int $certificateOfTitle,
		Gps $gps,
		string $municipalityPart,
		string $region,
		string $usage,
		array $addressPointCodes,
		string $portion,
		int $buildingId,
		string $buildingLabel
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
			$gps,
			$municipalityPart,
			$region,
			$usage,
			$addressPointCodes
		);

		$this->portion = $portion;
		$this->buildingId = $buildingId;
		$this->buildingLabel = $buildingLabel;
	}

	public function getPortion(): string
	{
		return $this->portion;
	}

	public function getBuildingId(): int
	{
		return $this->buildingId;
	}

	public function getBuildingLabel(): string
	{
		return $this->buildingLabel;
	}

}
