<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Client\Property;

use AsisTeam\ADOL\Entity\Property\Address;
use AsisTeam\ADOL\Entity\Property\Building;
use AsisTeam\ADOL\Entity\Property\BuildingUnitRelation;
use AsisTeam\ADOL\Entity\Property\LandBuildingRelation;
use AsisTeam\ADOL\Entity\Property\Ownership;
use AsisTeam\ADOL\Entity\Property\Sentence;
use AsisTeam\ADOL\Result\Property\Building\BuildingDetailHydrator;
use AsisTeam\ADOL\Result\Property\Common\OwnershipListHydrator;
use AsisTeam\ADOL\Result\Property\Relation\BuildingLandRelationHydrator;
use AsisTeam\ADOL\Result\Property\Relation\BuildingUnitRelationHydrator;

final class BuildingClient extends AbstractPropertyClient
{

	private const FIND = '/budovy/dotaz/';
	private const GET = '/budovy/%s';
	private const SENTENCES = '/budovy/%s/vety';
	private const UNITS = '/budovy/%s/jednotky';
	private const LANDS = '/budovy/%s/parcely';
	private const OWNERS = '/budovy/%s/vlastnici';

	/**
	 * @return Building[]
	 */
	public function findBuildings(Address $addr): array
	{
		$data = $this->request('GET', $this->getHost() . self::FIND . '?' . $this->createAddressQuery($addr));

		$buildings = [];
		foreach ($data as $item) {
			$buildings[] = BuildingDetailHydrator::fromArray($item);
		}

		return $buildings;
	}

	public function getBuilding(int $id): Building
	{
		$data = $this->request('GET', sprintf($this->getHost() . self::GET, $id));

		return BuildingDetailHydrator::fromArray($data);
	}

	/**
	 * @return Sentence[]
	 */
	public function getSentences(int $id): array
	{
		return $this->callGetSentences(self::SENTENCES, $id);
	}

	/**
	 * @return BuildingUnitRelation[]
	 */
	public function getUnits(int $id): array
	{
		$data = $this->request('GET', sprintf($this->getHost() . self::UNITS, $id));

		return BuildingUnitRelationHydrator::fromArray($data);
	}

	/**
	 * @return LandBuildingRelation[]
	 */
	public function getLands(int $id): array
	{
		$data = $this->request('GET', sprintf($this->getHost() . self::LANDS, $id));

		return BuildingLandRelationHydrator::fromArray($data);
	}

	/**
	 * @return Ownership[]
	 */
	public function getOwnerships(int $id): array
	{
		$data = $this->request('GET', sprintf($this->getHost() . self::OWNERS, $id));

		return OwnershipListHydrator::fromArray($data);
	}

}
