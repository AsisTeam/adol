<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Client\Property;

use AsisTeam\ADOL\Entity\Property\Address;
use AsisTeam\ADOL\Entity\Property\BuildingUnit;
use AsisTeam\ADOL\Entity\Property\Ownership;
use AsisTeam\ADOL\Entity\Property\Sentence;
use AsisTeam\ADOL\Result\Property\BuildingUnit\BuildingUnitDetailHydrator;
use AsisTeam\ADOL\Result\Property\Common\OwnershipListHydrator;

final class BuildingUnitClient extends AbstractPropertyClient
{

	private const FIND      = '/jednotky/dotaz/';
	private const GET       = '/jednotky/%s';
	private const SENTENCES = '/jednotky/%s/vety';
	private const OWNERS    = '/jednotky/%s/vlastnici';

	/**
	 * @return BuildingUnit[]
	 */
	public function findBuildingUnits(Address $addr): array
	{
		$data = $this->request('GET', $this->getHost() . self::FIND . '?' . $this->createAddressQuery($addr));

		$buildings = [];
		foreach ($data as $item) {
			$buildings[] = BuildingUnitDetailHydrator::fromArray($item);
		}

		return $buildings;
	}

	public function getUnit(int $id): BuildingUnit
	{
		$data = $this->request('GET', sprintf($this->getHost() . self::GET, $id));

		return BuildingUnitDetailHydrator::fromArray($data);
	}

	/**
	 * @return Ownership[]
	 */
	public function getOwnerships(int $id): array
	{
		$data = $this->request('GET', sprintf($this->getHost() . self::OWNERS, $id));

		return OwnershipListHydrator::fromArray($data);
	}

	/**
	 * @return Sentence[]
	 */
	public function getSentences(int $id): array
	{
		return $this->callGetSentences(self::SENTENCES, $id);
	}

}
