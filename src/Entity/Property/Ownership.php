<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\Property;

final class Ownership
{

	/** @var string */
	private $name;

	/** @var string */
	private $address;

	/** @var string */
	private $share;

	/** @var string */
	private $rightsType;

	public function __construct(
		string $name,
		string $address,
		string $share,
		string $rightsType
	)
	{
		$this->name       = $name;
		$this->address    = $address;
		$this->share      = $share;
		$this->rightsType = $rightsType;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getAddress(): string
	{
		return $this->address;
	}

	public function getShare(): string
	{
		return $this->share;
	}

	public function getRightsType(): string
	{
		return $this->rightsType;
	}

}
