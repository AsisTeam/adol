<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\Property;

final class Gps
{

	/** @var float */
	private $lat;

	/** @var float */
	private $lng;

	/** @var string|null */
	private $source;

	public function __construct(float $lat, float $lng, ?string $source = null)
	{
		$this->lat = $lat;
		$this->lng = $lng;
		$this->source = $source;
	}

	public function getLat(): float
	{
		return $this->lat;
	}

	public function getLng(): float
	{
		return $this->lng;
	}

	public function getSource(): ?string
	{
		return $this->source;
	}

}
