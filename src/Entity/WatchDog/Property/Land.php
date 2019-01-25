<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\WatchDog\Property;

final class Land extends Estate implements IEstate
{

	public const TYPE = 'land';

	public static function create(
		int $cadastralAreaCode,
		string $evidenceType,
		bool $isBuildingLand,
		int $kmenoveCislo
	): IEstate
	{
		$land = new self(self::TYPE);
		$land->setCadastralAreaCode($cadastralAreaCode); // Kód katastrálního území
		$land->setEvidenceType($evidenceType); // Typ evidence parcely - enum Estate::EVIDENCE_PKN or Estate::EVIDENCE_PZE
		$land->setIsBuildingLand($isBuildingLand); // Je stavební parcela?
		$land->setKmenoveCislo($kmenoveCislo); // Číslo parcely před lomítkem

		return $land;
	}

	public function isValid(): bool
	{
		return $this->ensureIsFilled([
			$this->estateType,
			$this->cadastralAreaCode,
			$this->evidenceType,
			$this->isBuildingLand,
			$this->kmenoveCislo,
		]);
	}

}
