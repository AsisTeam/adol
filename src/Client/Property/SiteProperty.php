<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Client\Property;

use AsisTeam\ADOL\Entity\Property\Building;
use AsisTeam\ADOL\Entity\Property\Ownership;
use AsisTeam\ADOL\Entity\Property\Sentence;
use AsisTeam\ADOL\Entity\Property\Site;
use AsisTeam\ADOL\Exception\ResponseException;
use AsisTeam\ADOL\Result\Property\SiteBuildingsResult;
use AsisTeam\ADOL\Result\Property\SiteDetailResult;
use AsisTeam\ADOL\Result\Property\SiteListResponse;
use AsisTeam\ADOL\Result\Property\SiteOwnershipResult;
use AsisTeam\ADOL\Result\Property\SiteSentencesResult;

final class SiteProperty extends AbstractPropertyClient
{

	private const LIST      = '/parcely/dotaz/?parcelaCislo=%s&katUzemi=%s';
	private const DETAIL    = '/parcely/%s';
	private const OWNERS    = '/parcely/%s/vlastnici';
	private const BUILDINGS = '/parcely/%s/budova';
	private const SENTENCES = '/parcely/%s/vety';

	/**
	 * @return Site[]
	 */
	public function listSites(int $kmenoveCislo, string $cadastralAreaName): array
	{
		$area = urlencode($cadastralAreaName);
		$data = $this->request('GET', sprintf(self::HOST . self::PATH . self::LIST, $kmenoveCislo, $area), []);

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

}
