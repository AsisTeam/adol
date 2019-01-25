<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\WatchDog\Insolvency;

use DateTimeImmutable;

final class Change
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
	private $creditor;

	/** @var string|null */
	private $description;

	/** @var Record|null */
	private $record;

	/**
	 * @param mixed[] $data
	 */
	public static function fromArray(array $data): self
	{
		$ch = new Change();

		$ch->isir        = $data['isir'] ?? null;
		$ch->merge       = $data['merge'] ?? null;
		$ch->part        = $data['part'] ?? null;
		$ch->description = $data['description'] ?? null;
		$ch->creditor    = $data['creditor'] ?? null;
		$ch->order       = isset($data['order']) ? (int) $data['order'] : null;
		$ch->subOrder    = isset($data['subOrder']) ? (int) $data['subOrder'] : null;
		$ch->mainDocId   = isset($data['mainDocId']) ? (int) $data['mainDocId'] : null;
		$ch->mainDocUrl  = $data['mainDocUrl'] ?? null;
		$ch->subDocId    = isset($data['subDocId']) ? (int) $data['subDocId'] : null;
		$ch->subDocUrl   = $data['subDocUrl'] ?? null;

		$ch->created = isset($data['timeCreated']) ? new DateTimeImmutable($data['timeCreated']) : null;

		if (isset($data['record'])) {
			$ch->record = Record::fromArray($data['record']);
		}

		return $ch;
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

	public function getCreditor(): ?string
	{
		return $this->creditor;
	}

	public function getRecord(): ?Record
	{
		return $this->record;
	}

}
