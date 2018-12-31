<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\WatchDog;

final class BuildingUnit extends Realty implements IEstate
{

	public const TYPE = 'unit';

	public static function create(
		int $villagePart,
		int $homeNumberType,
		int $homeNumber,
		int $unit
	): IEstate
	{
		$bu = new self(self::TYPE);
		$bu->setVillagePart($villagePart);
		$bu->setHomeNumberType($homeNumberType);
		$bu->setHomeNumber($homeNumber);
		$bu->setUnit($unit);

		return $bu;
	}

	public function isValid(): bool
	{
		return $this->ensureIsFilled([
			$this->estateType,
			$this->villagePart,
			$this->homeNumberType,
			$this->homeNumber,
		]);
	}

}
