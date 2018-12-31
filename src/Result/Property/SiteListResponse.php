<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\Property;

use AsisTeam\ADOL\Entity\Site\Site;
use AsisTeam\ADOL\Exception\ResponseException;

final class SiteListResponse
{

	/**
	 * @param mixed[] $data
	 * @return Site[]
	 */
	public static function fromArray(array $data): array
	{
		$sites = [];

		foreach ($data as $key => $siteData) {
			if (!isset($siteData['id'])) {
				throw new ResponseException(sprintf('Site at pos #%d does not have id field.', $key));
			}

			$sites[] = SiteDetailResult::fromArray($siteData['id'], $siteData);
		}

		return $sites;
	}

}
