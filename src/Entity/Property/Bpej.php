<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\Property;

/**
 * Bpej stands for "Bonitovaná Půdně Ekologická Jednotka"
 */
final class Bpej
{

	/** @var float */
	private $total;

	/** @var float */
	private $meterAverage;

	/** @var float */
	private $excavation;

	public function __construct(float $total, float $meterAverage, float $excavation)
	{
		$this->total        = $total;
		$this->meterAverage = $meterAverage;
		$this->excavation   = $excavation;
	}

	public function getTotal(): float
	{
		return $this->total;
	}

	public function getMeterAverage(): float
	{
		return $this->meterAverage;
	}

	public function getExcavation(): float
	{
		return $this->excavation;
	}

}
