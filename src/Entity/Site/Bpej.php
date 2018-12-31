<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\Site;

/**
 * Bpej stands for "Bonitovaná Půdně Ekologická Jednotka"
 */
final class Bpej
{

	/** @var int */
	private $total;

	/** @var int */
	private $meterAverage;

	/** @var int */
	private $excavation;

	public function __construct(int $total, int $meterAverage, int $excavation)
	{
		$this->total        = $total;
		$this->meterAverage = $meterAverage;
		$this->excavation   = $excavation;
	}

	public function getTotal(): int
	{
		return $this->total;
	}

	public function getMeterAverage(): int
	{
		return $this->meterAverage;
	}

	public function getExcavation(): int
	{
		return $this->excavation;
	}

}
