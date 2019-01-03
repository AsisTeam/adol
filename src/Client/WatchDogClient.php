<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Client;

use AsisTeam\ADOL\Entity\WatchDog\IEstate;
use AsisTeam\ADOL\Exception\RequestException;
use AsisTeam\ADOL\Exception\ResponseException;
use AsisTeam\ADOL\Result\WatchDog\Insertion;
use AsisTeam\ADOL\Result\WatchDog\Record;

final class WatchDogClient extends AbstractClient
{

	private const API = '/papi/property-watchdog';

	private const PATH_LIST = '/list';
	private const PATH_INSERT = '/insert';
	private const PATH_DELETE = '/remove';
	private const PATH_DETAIL = '/detail';

	public function insert(IEstate $estate): Insertion
	{
		if ($estate->isValid() === false) {
			throw new RequestException('Trying to insert invalid estate. please check it\'s mandatory fields.');
		}

		$data = $this->request('POST', $this->getUrl(self::PATH_INSERT), ['form_params' => $estate->toArray()]);

		return Insertion::fromArray($data);
	}

	/**
	 * @return Record[]
	 */
	public function list(int $page, ?int $limit = 10): array
	{
		$resp = $this->request('POST', $this->getUrl(self::PATH_LIST), ['form_params' => ['page' => $page, 'limit' => $limit]]);

		if (!array_key_exists('records', $resp)) {
			throw new ResponseException('Missing "records" field in "list" response');
		}

		$out = [];
		foreach ($resp['records'] as $rec) {
			$out[] = Record::fromArray($rec);
		}

		return $out;
	}

	public function detail(string $id): Record
	{
		$data = $this->request('POST', $this->getUrl(self::PATH_DETAIL), ['form_params' => ['id' => $id]]);

		if (!array_key_exists('record', $data)) {
			throw new ResponseException('Missing "record" field in "detail" response');
		}

		return Record::fromArray($data['record']);
	}

	public function delete(string $id): void
	{
		$this->request('POST', $this->getUrl(self::PATH_DELETE), ['form_params' => ['id' => $id]]);
	}

	private function getUrl(string $path): string
	{
		return self::HOST . self::API . $path;
	}

}
