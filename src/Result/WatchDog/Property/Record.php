<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\WatchDog\Property;

use AsisTeam\ADOL\Entity\WatchDog\Property\Estate;
use AsisTeam\ADOL\Result\WatchDog\Change;
use DateTimeImmutable;

final class Record
{

	/** @var mixed[] */
	private $raw;

	/** @var string */
	private $id;

	/** @var DateTimeImmutable */
	private $timeCreated;

	/** @var string */
	private $title;

	/** @var string */
	private $name;

	/** @var int|null */
	private $lv;

	/** @var string */
	private $status;

	/** @var string[] */
	private $owners = [];

	/** @var string[] */
	private $procedures = [];

	/** @var string[] */
	private $activeProcedures = [];

	/** @var string[] */
	private $restricts = [];

	/** @var Change[] */
	private $changes = [];

	/** @var string[]  */
	private $shortNotes = [];

	/** @var string */
	private $cadastralUrl;

	/** @var Estate */
	private $estate;

	/**
	 * @param mixed[] $a
	 */
	public static function fromArray(array $a): self
	{
		$rec      = new self();
		$rec->raw = $a;

		$rec->id          = $a['id'];
		$rec->timeCreated = new DateTimeImmutable($a['timeCreated']);
		$rec->title       = $a['title'];
		$rec->name        = $a['name'];
		$rec->lv          = isset($a['lv']) && is_numeric($a['lv']) ? (int) $a['lv'] : null;
		$rec->status      = $a['status'];
		$rec->cadastralUrl      = $a['cadastralUrl'];

		$rec->owners     = $a['owners'] ?? [];
		$rec->procedures = $a['procedures'] ?? [];
		$rec->activeProcedures = $a['activeProcedures'] ?? [];
		$rec->restricts  = $a['restricts'] ?? [];
		$rec->shortNotes  = $a['shortNotes'] ?? [];

		if (isset($a['changes'])) {
			foreach ($a['changes'] as $ch) {
				$rec->changes[] = Change::fromArray($ch);
			}
		}

		if (isset($a['estate'])) {
			$rec->estate = Estate::fromArray($a['estate']);
		}

		return $rec;
	}

	/**
	 * @return mixed[]
	 */
	public function getRaw(): array
	{
		return $this->raw;
	}

	public function getId(): string
	{
		return $this->id;
	}

	public function getTimeCreated(): DateTimeImmutable
	{
		return $this->timeCreated;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getLv(): ?int
	{
		return $this->lv;
	}

	public function getStatus(): string
	{
		return $this->status;
	}

	/**
	 * @return string[]
	 */
	public function getOwners(): array
	{
		return $this->owners;
	}

	/**
	 * @return string[]
	 */
	public function getProcedures(): array
	{
		return $this->procedures;
	}

	/**
	 * @return string[]
	 */
	public function getRestricts(): array
	{
		return $this->restricts;
	}

	/**
	 * @return Change[]
	 */
	public function getChanges(): array
	{
		return $this->changes;
	}

	/**
	 * @return string[]
	 */
	public function getActiveProcedures(): array
	{
		return $this->activeProcedures;
	}

	/**
	 * @return string[]
	 */
	public function getShortNotes(): array
	{
		return $this->shortNotes;
	}

	public function getCadastralUrl(): string
	{
		return $this->cadastralUrl;
	}

	public function getEstate(): Estate
	{
		return $this->estate;
	}

}
