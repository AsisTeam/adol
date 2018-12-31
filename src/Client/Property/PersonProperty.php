<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Client\Property;

use AsisTeam\ADOL\Entity\Property\Person;
use AsisTeam\ADOL\Entity\Property\Site;
use AsisTeam\ADOL\Result\Property\PersonListResult;
use AsisTeam\ADOL\Result\Property\PersonSitesResult;

final class PersonProperty extends AbstractPropertyClient
{

	private const FIND  = '/osoby/najit';
	private const GET   = '/osoby/hledat';
	private const SITES = '/osoby/%s/parcely';

	/**
	 * @return Person[]
	 */
	public function findPerson(Person $p): array
	{
		$url  = self::HOST . self::PATH . self::FIND . '?' . $this->createPersonQuery($p);
		$data = $this->request('GET', $url, []);

		return PersonListResult::fromArray($data);
	}

	/**
	 * @return Person[]
	 */
	public function getPerson(Person $p): array
	{
		$url  = self::HOST . self::PATH . self::GET . '?' . $this->createPersonQuery($p);
		$data = $this->request('GET', $url, []);

		return PersonListResult::fromArray($data);
	}

	/**
	 * @return Site[]
	 */
	public function getSites(int $personId): array
	{
		$url  = sprintf(self::HOST . self::PATH . self::GET . self::SITES, $personId);
		$data = $this->request('GET', $url, []);

		return PersonSitesResult::fromArray($data);
	}

	private function createPersonQuery(Person $p): string
	{
		$data = [
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
		];

		$clean = array_filter($data, 'strlen');

		return http_build_query($clean);
	}

}
