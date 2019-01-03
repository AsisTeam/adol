<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Client\Property;

use AsisTeam\ADOL\Entity\Property\Sentence;

final class BuildingUnitClient extends AbstractPropertyClient
{

//	private const FIND = '/jednotky/dotaz/';
//	private const GET = '/jednotky/%s';
	private const SENTENCES = '/jednotky/%s/vety';


//	public function getUnit(int $id)
//	{
//		$data = $this->request('GET', sprintf($this->getHost() . self::GET, $id));
//
//		var_dump($data); die();
//	}

	/**
	 * @return Sentence[]
	 */
	public function getSentences(int $id): array
	{
		return $this->callGetSentences(self::SENTENCES, $id);
	}

}
