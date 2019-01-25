<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Client\WatchDog;

use AsisTeam\ADOL\Client\AbstractClient;
use AsisTeam\ADOL\Entity\WatchDog\Property\IEstate;
use AsisTeam\ADOL\Exception\RequestException;
use AsisTeam\ADOL\Exception\ResponseException;
use AsisTeam\ADOL\Result\WatchDog\Property\Change;
use AsisTeam\ADOL\Result\WatchDog\Property\Insertion;
use AsisTeam\ADOL\Result\WatchDog\Property\Record;
use DateTimeImmutable;

final class PropertyClient extends AbstractClient
{

	private const API = '/papi/property-watchdog';

	private const PATH_LIST = '/list';
	private const PATH_INSERT = '/insert';
	private const PATH_DELETE = '/remove';
	private const PATH_DETAIL = '/detail';
	private const PATH_CHANGES = '/changes';

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
		$data = $this->request('POST', $this->getUrl(self::PATH_LIST), ['form_params' => ['page' => $page, 'limit' => $limit]]);

		if (!array_key_exists('records', $data)) {
			throw new ResponseException('Missing "records" field in "list" response');
		}

		$out = [];
		foreach ($data['records'] as $rec) {
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

	/**
	 * @return Change[]
	 */
	public function changes(DateTimeImmutable $from): array
	{
		$data = $this->request('POST', $this->getUrl(self::PATH_CHANGES), ['form_params' => ['from' => $from->format('Y-m-d')]]);

		if (!array_key_exists('changes', $data)) {
			throw new ResponseException('Missing "changes" field in "changes" response');
		}

		$out = [];
		foreach ($data['changes'] as $rec) {
			$out[] = Change::fromArray($rec);
		}

		return $out;
	}

	private function getUrl(string $path): string
	{
		return self::HOST . self::API . $path;
	}

}
