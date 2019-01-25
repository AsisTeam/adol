<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\WatchDog\Property;

final class Building extends Estate implements IEstate
{

	public const TYPE = 'building';

	public static function create(
		int $villagePartCode,
		int $homeNumberType,
		int $houseNumber
	): IEstate
	{
		$b = new self(self::TYPE);
		$b->setVillagePart($villagePartCode);
		$b->setHomeNumberType($homeNumberType);
		$b->setHomeNumber($houseNumber);

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
