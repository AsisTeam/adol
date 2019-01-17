<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\WatchDog\Insolvency;

use DateTimeImmutable;

final class Detail
{

	/** @var string|null */
	private $isir;

	/** @var bool|null */
	private $merge;

	/** @var string|null */
	private $part;

	/** @var int|null */
	private $order;

	/** @var int|null */
	private $subOrder;

	/** @var DateTimeImmutable|null */
	private $created;

	/** @var int|null */
	private $mainDocId;

	/** @var string|null */
	private $mainDocUrl;

	/** @var int|null */
	private $subDocId;

	/** @var string|null */
	private $subDocUrl;

	/** @var string|null */
	private $description;

	/**
	 * @param mixed[] $data
	 */
	public static function fromArray(array $data): self
	{
		$d = new Detail();

		$d->isir        = $data['isir'] ?? null;
		$d->merge       = $data['merge'] ?? null;
		$d->part        = $data['part'] ?? null;
		$d->description = $data['description'] ?? null;
		$d->order       = $data['order'] ?? null;
		$d->subOrder    = $data['subOrder'] ?? null;
		$d->mainDocId   = $data['mainDocId'] ?? null;
		$d->mainDocUrl  = $data['mainDocUrl'] ?? null;
		$d->subDocId    = $data['subDocId'] ?? null;
		$d->subDocUrl   = $data['subDocUrl'] ?? null;

		$d->created = isset($data['timeCreated']) ? new DateTimeImmutable($data['timeCreated']) : null;

		return $d;
	}

	public function getIsir(): ?string
	{
		return $this->isir;
	}

	public function getMerge(): ?bool
	{
		return $this->merge;
	}

	public function getPart(): ?string
	{
		return $this->part;
	}

	public function getOrder(): ?int
	{
		return $this->order;
	}

	public function getSubOrder(): ?int
	{
		return $this->subOrder;
	}

	public function getCreated(): ?DateTimeImmutable
	{
		return $this->created;
	}

	public function getMainDocId(): ?int
	{
		return $this->mainDocId;
	}

	public function getMainDocUrl(): ?string
	{
		return $this->mainDocUrl;
	}

	public function getSubDocId(): ?int
	{
		return $this->subDocId;
	}

	public function getSubDocUrl(): ?string
	{
		return $this->subDocUrl;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

}
