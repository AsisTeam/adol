<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\WatchDog\Insolvency;

use AsisTeam\ADOL\Exception\LogicalException;
use DateTimeImmutable;

final class Record
{

	/** @var mixed[] */
	private $raw;

	/** @var string|null */
	private $id;

	/** @var string|null */
	private $personalId;

	/** @var string|null */
	private $companyId;

	/** @var string|null */
	private $name;

	/** @var string|null */
	private $surname;

	/** @var DateTimeImmutable|null */
	private $birthDate;

	/** @var string|null */
	private $address;

	/** @var string[] */
	private $subjectNames = [];

	/** @var string[] */
	private $subjectPersonalIds = [];

	/** @var string[] */
	private $subjectCompanyIds = [];

	/** @var string[] */
	private $subjectBirthDates = [];

	/** @var DateTimeImmutable|null */
	private $created;

	/** @var Insolvency[] */
	private $insolvencies = [];

	/** @var Change[] */
	private $changes = [];

	/**
	 * @param mixed[] $data
	 */
	public static function fromArray(array $data): self
	{
		$rec = new self();

		$rec->raw        = $data;
		$rec->id         = isset($data['id']) ? (string) $data['id'] : null;
		$rec->personalId = $data['rc'] ?? null;
		$rec->companyId  = $data['ic'] ?? null;
		$rec->surname    = $data['surname'] ?? null;
		$rec->name       = $data['name'] ?? null;
		$rec->address    = $data['address'] ?? null;
		$rec->birthDate  = isset($data['dateBirth']) ? new DateTimeImmutable($data['dateBirth']) : null;
		$rec->created    = isset($data['timeCreated']) ? new DateTimeImmutable($data['timeCreated']) : null;

		$rec->subjectNames = $data['subjectsName'] ?? [];
		$rec->subjectPersonalIds = $data['subjectsRc'] ?? [];
		$rec->subjectCompanyIds = $data['subjectsIc'] ?? [];
		$rec->subjectBirthDates = $data['subjectsDateBirth'] ?? [];

		if (isset($data['insolvencies']) && is_array($data['insolvencies'])) {
			foreach ($data['insolvencies'] as $ins) {
				$rec->insolvencies[] = Insolvency::fromArray($ins);
			}
		}

		if (isset($data['changes']) && is_array($data['changes'])) {
			foreach ($data['changes'] as $ch) {
				$rec->changes[] = Change::fromArray($ch);
			}
		}

		return $rec;
	}

	public function isCompany(): bool
	{
		$this->validate();

		return $this->companyId !== null;
	}

	public function isPerson(): bool
	{
		$this->validate();

		return $this->personalId !== null;
	}

	public function validate(): void
	{
		if ($this->companyId === null && $this->personalId === null) {
			throw new LogicalException('Record subject is not either company or person.');
		}

		if ($this->companyId !== null && $this->personalId !== null) {
			throw new LogicalException('Record subject cannot be company and subject combined.');
		}

		// either companyId or personalId is set -> valid
	}

	/**
	 * @return mixed[]
	 */
	public function getRaw(): array
	{
		return $this->raw;
	}

	public function getId(): ?string
	{
		return $this->id;
	}

	public function getPersonalId(): ?string
	{
		return $this->personalId;
	}

	public function getCompanyId(): ?string
	{
		return $this->companyId;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function getSurname(): ?string
	{
		return $this->surname;
	}

	public function getBirthDate(): ?DateTimeImmutable
	{
		return $this->birthDate;
	}

	public function getAddress(): ?string
	{
		return $this->address;
	}

	/**
	 * @return string[]
	 */
	public function getSubjectNames(): array
	{
		return $this->subjectNames;
	}

	/**
	 * @return string[]
	 */
	public function getSubjectPersonalIds(): array
	{
		return $this->subjectPersonalIds;
	}

	/**
	 * @return string[]
	 */
	public function getSubjectCompanyIds(): array
	{
		return $this->subjectCompanyIds;
	}

	/**
	 * @return string[]
	 */
	public function getSubjectBirthDates(): array
	{
		return $this->subjectBirthDates;
	}

	public function getCreated(): ?DateTimeImmutable
	{
		return $this->created;
	}

	/**
	 * @return Insolvency[]
	 */
	public function getInsolvencies(): array
	{
		return $this->insolvencies;
	}

	/**
	 * @return Change[]
	 */
	public function getChanges(): array
	{
		return $this->changes;
	}

}
