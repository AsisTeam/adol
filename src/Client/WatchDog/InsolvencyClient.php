<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Client\WatchDog;

use AsisTeam\ADOL\Client\AbstractClient;
use AsisTeam\ADOL\Entity\WatchDog\Insolvency\ISubject;
use AsisTeam\ADOL\Exception\RequestException;
use AsisTeam\ADOL\Exception\ResponseException;
use AsisTeam\ADOL\Result\WatchDog\Change;
use AsisTeam\ADOL\Result\WatchDog\Insertion;
use AsisTeam\ADOL\Result\WatchDog\Insolvency\Record;
use DateTimeImmutable;

final class InsolvencyClient extends AbstractClient
{

	private const API = '/papi/insolvency-watchdog';

	private const PATH_LIST = '/list';
	private const PATH_INSERT = '/insert';
	private const PATH_DELETE = '/remove';
	private const PATH_DETAIL = '/detail';
	private const PATH_CHANGES = '/changes';

	public function insert(ISubject $insolvency): Insertion
	{
		if ($insolvency->isValid() === false) {
			throw new RequestException('Trying to insert invalid insolvency. please check it\'s mandatory fields.');
		}

		$data = $this->request('POST', $this->getUrl(self::PATH_INSERT), ['form_params' => $insolvency->toArray()]);

		return Insertion::fromArray($data);
	}

	/**
	 * @return Record[]
	 */
	public function list(int $page, ?int $limit = 10): array
	{
		$data = $this->request('POST', $this->getUrl(self::PATH_LIST), ['form_params' => ['page' => $page, 'limit' => $limit]]);

		if (!array_key_exists('insolvencies', $data)) {
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
