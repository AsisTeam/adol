<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Client\Property;

use AsisTeam\ADOL\Entity\Property\Address;
use AsisTeam\ADOL\Entity\Property\Building;
use AsisTeam\ADOL\Entity\Property\BuildingUnit;
use AsisTeam\ADOL\Entity\Property\Land;
use AsisTeam\ADOL\Entity\Property\Ownership;
use AsisTeam\ADOL\Entity\Property\Sentence;
use AsisTeam\ADOL\Result\Property\Building\BuildingDetailHydrator;
use AsisTeam\ADOL\Result\Property\BuildingUnit\BuildingUnitListHydrator;
use AsisTeam\ADOL\Result\Property\Common\OwnershipListHydrator;
use AsisTeam\ADOL\Result\Property\Land\LandListHydrator;

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
	public function findBuildings(
		string $region,
		string $municipality,
		string $municipalityPart,
		string $houseNumber, // popisne cislo
		?string $registrationNumber = null // evidencni cislo
	): array
	{
		$addr = Address::fromSearchParams($region, $municipality, $municipalityPart, $houseNumber, $registrationNumber);

		return $this->findBuildingsByAddress($addr);
	}

	/**
	 * @return Building[]
	 */
	public function findBuildingsByAddress(Address $addr): array
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
	 * @return BuildingUnit[]
	 */
	public function getUnits(int $id): array
	{
		$data = $this->request('GET', sprintf($this->getHost() . self::UNITS, $id));

		if (!isset($data['jednotky']) || !is_array($data['jednotky'])) {
			return [];
		}

		return BuildingUnitListHydrator::fromArray($data['jednotky']);
	}

	/**
	 * @return Land[]
	 */
	public function getLands(int $id): array
	{
		$data = $this->request('GET', sprintf($this->getHost() . self::LANDS, $id));

		if (!isset($data['parcely']) || !is_array($data['parcely'])) {
			return [];
		}

		return LandListHydrator::fromArray($data['parcely']);
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
