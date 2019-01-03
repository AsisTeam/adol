<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\Property;

class Building extends Realty
{

	/** @var string */
	protected $municipalityPart;

	/** @var string */
	protected $region;

	/** @var string */
	protected $usage;

	/** @var int[] */
	protected $addressPointCodes;

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
		string $region,
		string $municipalityPart,
		string $usage,
		array $addressPointCodes
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

		$this->region            = $region;
		$this->municipalityPart  = $municipalityPart;
		$this->usage             = $usage;
		$this->addressPointCodes = $addressPointCodes;
	}

	public function getMunicipalityPart(): string
	{
		return $this->municipalityPart;
	}

	public function getRegion(): string
	{
		return $this->region;
	}

	public function getUsage(): string
	{
		return $this->usage;
	}

	/**
	 * @return int[]
	 */
	public function getAddressPointCodes(): array
	{
		return $this->addressPointCodes;
	}

}
