<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\WatchDog\Property;

final class BuildingUnit extends Estate implements IEstate
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
		$bu->setVillagePart($villagePart); // kod casti obce
		$bu->setHomeNumberType($homeNumberType); // typ domovniho cisla - enum Estate::HOME_NUMBER_XXX
		$bu->setHomeNumber($homeNumber); // domovni cislo
		$bu->setUnit($unit); // cislo jednotky

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
