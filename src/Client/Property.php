<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Client;

use AsisTeam\ADOL\Entity\Site\Building;
use AsisTeam\ADOL\Entity\Site\Ownership;
use AsisTeam\ADOL\Entity\Site\Sentence;
use AsisTeam\ADOL\Entity\Site\Site;
use AsisTeam\ADOL\Exception\ResponseException;
use AsisTeam\ADOL\Result\Property\SiteBuildingsResult;
use AsisTeam\ADOL\Result\Property\SiteDetailResult;
use AsisTeam\ADOL\Result\Property\SiteListResponse;
use AsisTeam\ADOL\Result\Property\SiteOwnershipResult;
use AsisTeam\ADOL\Result\Property\SiteSentencesResult;

final class Property extends AbstractClient
{

	private const PATH      = '/papi/property';

	private const LIST      = '/parcely/dotaz/?parcelaCislo=%s&katUzemi=%s';
	private const DETAIL    = '/parcely/%s';
	private const OWNERS    = '/parcely/%s/vlastnici';
	private const BUILDINGS = '/parcely/%s/budova';
	private const SENTENCES = '/parcely/%s/vety';

	/**
	 * @return mixed[]
	 */
	public function listSites(int $kmenoveCislo, string $cadAreaName): array
	{
		$data = $this->request('GET', sprintf(self::HOST . self::PATH . self::LIST, $kmenoveCislo, $cadAreaName), []);

		return SiteListResponse::fromArray($data);
	}

	public function getSiteDetail(int $siteId): Site
	{
		$data = $this->request('GET', sprintf(self::HOST . self::PATH . self::DETAIL, $siteId), []);

		if (!array_key_exists('id', $data) || $data['id'] !== $siteId) {
			throw new ResponseException('Returned siteId does not match requested id.');
		}

		return SiteDetailResult::fromArray($siteId, $data);
	}

	/**
	 * @return Ownership[]
	 */
	public function getSiteOwnerships(int $siteId): array
	{
		$data = $this->request('GET', sprintf(self::HOST . self::PATH . self::OWNERS, $siteId), []);

		return SiteOwnershipResult::fromArray($siteId, $data);
	}

	/**
	 * @return Building[]
	 */
	public function getSiteBuildings(int $siteId): array
	{
		$data = $this->request('GET', sprintf(self::HOST . self::PATH . self::BUILDINGS, $siteId), []);

		return SiteBuildingsResult::fromArray($siteId, $data);
	}

	/**
	 * @return Sentence[]
	 */
	public function getSiteSentences(int $siteId): array
	{
		$data = $this->request('GET', sprintf(self::HOST . self::PATH . self::SENTENCES, $siteId), []);

		return SiteSentencesResult::fromArray($siteId, $data);
	}

	/**
	 * @param mixed[] $params
	 * @return mixed[]
	 */
	protected function request(string $method, string $url, array $params): array
	{
		$resp = parent::request($method, $url, $params);

		if (!array_key_exists('data', $resp)) {
			throw new ResponseException('Mandatory "data" field missing in response data.');
		}

		return $resp['data'];
	}

}
