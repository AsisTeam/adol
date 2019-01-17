<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\WatchDog\Insolvency;

final class Administrator
{

	/** @var string */
	private $name;

	/** @var string */
	private $address;

	public function __construct(string $name = '', string $address = '')
	{
		$this->name = $name;
		$this->address = $address;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getAddress(): string
	{
		return $this->address;
	}

}
