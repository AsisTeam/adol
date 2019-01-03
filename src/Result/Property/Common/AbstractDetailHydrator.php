<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\Property\Common;

use AsisTeam\ADOL\Exception\ResponseException;
use Throwable;

abstract class AbstractDetailHydrator
{

	/**
	 * @param mixed[] $data
	 */
	protected static function throwHydrationError(Throwable $e, array $data): void
	{
		throw new ResponseException(
			sprintf(
				'Cannot hydrate object from response data. Error: %s, Data: %s',
				$e->getMessage(),
				json_encode($data)
			),
			$e->getCode(),
			$e
		);
	}

}
