<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\Estate;

use AsisTeam\ADOL\Entity\Estate;

final class Building extends Estate implements IEstate
{

	public const TYPE = 'building';

	public static function create(
		int $villagePart,
		int $homeNumberType,
		int $homeNumber
	): IEstate
	{
		$b = new self(self::TYPE);
		$b->setVillagePart($villagePart);
		$b->setHomeNumberType($homeNumberType);
		$b->setHomeNumber($homeNumber);

		return $b;
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
