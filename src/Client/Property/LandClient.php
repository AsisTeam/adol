<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Client\Property;

use AsisTeam\ADOL\Entity\Property\Land;
use AsisTeam\ADOL\Entity\Property\LandBuildingRelation;
use AsisTeam\ADOL\Entity\Property\Ownership;
use AsisTeam\ADOL\Entity\Property\Sentence;
use AsisTeam\ADOL\Result\Property\Land\LandBuildingRelationHydrator;
use AsisTeam\ADOL\Result\Property\Land\LandDetailHydrator;
use AsisTeam\ADOL\Result\Property\Land\LandListHydrator;
use AsisTeam\ADOL\Result\Property\Land\LandOwnershipHydrator;

final class LandClient extends AbstractPropertyClient
{

	private const LIST      = '/parcely/dotaz/?parcelaCislo=%s&katUzemi=%s';
	private const DETAIL    = '/parcely/%s';
	private const OWNERS    = '/parcely/%s/vlastnici';
	private const BUILDINGS = '/parcely/%s/budova';
	private const SENTENCES = '/parcely/%s/vety';

	/**
	 * @return Land[]
	 */
	public function findLands(int $kmenoveCislo, string $cadastralAreaName): array
	{
		$area = urlencode($cadastralAreaName);
		$data = $this->request('GET', sprintf($this->getHost() . self::LIST, $kmenoveCislo, $area));

		return LandListHydrator::fromArray($data);
	}

	public function getLand(int $id): Land
	{
		$data = $this->request('GET', sprintf($this->getHost() . self::DETAIL, $id));

		return LandDetailHydrator::fromArray($data);
	}

	/**
	 * @return Ownership[]
	 */
	public function getLandOwnerships(int $id): array
	{
		$data = $this->request('GET', sprintf($this->getHost() . self::OWNERS, $id));

		return LandOwnershipHydrator::fromArray($data);
	}

	/**
	 * @return LandBuildingRelation[]
	 */
	public function getLandBuildings(int $id): array
	{
		$data = $this->request('GET', sprintf($this->getHost() . self::BUILDINGS, $id));

		return LandBuildingRelationHydrator::fromArray($data);
	}

	/**
	 * @return Sentence[]
	 */
	public function getLandSentences(int $id): array
	{
		return $this->callGetSentences(self::SENTENCES, $id);
	}

}
