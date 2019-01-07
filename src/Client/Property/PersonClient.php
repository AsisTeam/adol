<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Client\Property;

use AsisTeam\ADOL\Entity\Property\Building;
use AsisTeam\ADOL\Entity\Property\BuildingUnit;
use AsisTeam\ADOL\Entity\Property\Land;
use AsisTeam\ADOL\Entity\Property\Person;
use AsisTeam\ADOL\Result\Property\Person\PersonBuildingsHydrator;
use AsisTeam\ADOL\Result\Property\Person\PersonLandsHydrator;
use AsisTeam\ADOL\Result\Property\Person\PersonListHydrator;
use AsisTeam\ADOL\Result\Property\Person\PersonUnitsHydrator;

final class PersonClient extends AbstractPropertyClient
{

	private const FIND      = '/osoby/najit';
	private const GET       = '/osoby/hledat';
	private const SITES     = '/osoby/%s/parcely';
	private const BUILDINGS = '/osoby/%s/budovy';
	private const UNITS     = '/osoby/%s/jednotky';

	/**
	 * @return Person[]
	 */
	public function findPerson(Person $p): array
	{
		$data = $this->request('GET', $this->getHost() . self::FIND . '?' . $this->createPersonQuery($p));

		return PersonListHydrator::fromArray($data);
	}

	/**
	 * @return Person[]
	 */
	public function getPerson(Person $p): array
	{
		$data = $this->request('GET', $this->getHost() . self::GET . '?' . $this->createPersonQuery($p));

		return PersonListHydrator::fromArray($data);
	}

	/**
	 * @return Land[]
	 */
	public function getLands(int $id): array
	{
		$data = $this->request('GET', sprintf($this->getHost() . self::SITES, $id));

		return PersonLandsHydrator::fromArray($data);
	}

	/**
	 * @return Building[]
	 */
	public function getBuildings(int $personId): array
	{
		$data = $this->request('GET', sprintf($this->getHost() . self::BUILDINGS, $personId));

		return PersonBuildingsHydrator::fromArray($data);
	}

	/**
	 * @return BuildingUnit[]
	 */
	public function getUnits(int $personId): array
	{
		$data = $this->request('GET', sprintf($this->getHost() . self::UNITS, $personId));

		return PersonUnitsHydrator::fromArray($data);
	}

	private function createPersonQuery(Person $p): string
	{
		return $this->createQuery(
			[
				'prijmeni'  => $p->getLastName(),
				'jmeno'     => $p->getFirstName(),
				'titulPred' => $p->getDegreePrefix(),
				'titulZa'   => $p->getDegreeSuffix(),
				'obec'      => $p->getMunicipality(),
				'okres'     => $p->getRegion(),
				'rc'        => $p->getPersonalId(),
				'den'       => $p->getDayOfBirth(),
				'mesic'     => $p->getMonthOfBirth(),
				'rok'       => $p->getYearOfBirth(),
				'ico'       => $p->getCompanyId(),
				'nazev'     => $p->getCompanyName(),
			]
		);
	}

}
