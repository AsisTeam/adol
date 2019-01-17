<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\WatchDog\Insolvency;

use AsisTeam\ADOL\Entity\WatchDog\Insolvency\Subject;
use DateTimeImmutable;

final class Insolvency
{

	/** @var string|null */
	private $isir;

	/** @var DateTimeImmutable|null */
	private $created;

	/** @var DateTimeImmutable|null */
	private $lastChange;

	/** @var string|null */
	private $rowId;

	/** @var string|null */
	private $office;

	/** @var string|null */
	private $status;

	/** @var Detail|null */
	private $detail;

	/** @var Subject[] */
	private $subjects = [];

	/** @var Administrator[] */
	private $administrators = [];

	/** @var string[] */
	private $mergeRecords = [];

	/**
	 * @param mixed[] $data
	 */
	public static function fromArray(array $data): self
	{
		$ins = new Insolvency();

		$ins->isir = $data['isir'] ?? null;
		$ins->rowId = $data['rowId'] ?? null;
		$ins->office = $data['office'] ?? null;
		$ins->status = $data['status'] ?? null;

		// TODO - check the field name
		$ins->detail = isset($data['record']) ? Detail::fromArray($data['record']) : null;

		$ins->created = isset($data['insolvencyCreated']) ? new DateTimeImmutable($data['insolvencyCreated']) : null;
		$ins->lastChange = isset($data['insolvencyLastChange']) ? new DateTimeImmutable($data['insolvencyLastChange']) : null;

		$ins->mergeRecords = $data['mergeRecords'] ?? [];

		if (isset($data['subjects']) && is_array($data['subjects'])) {
			foreach ($data['subjects'] as $s) {
				$subject = new Subject();
				$subject->setName($s['name'] ?? null);
				$subject->setCompanyId($s['ic'] ?? null);
				$subject->setPersonalId($s['rc'] ?? null);
				$subject->setAddress($s['address'] ?? null);
				$subject->setDateBirth(isset($s['dateBirth']) ? new DateTimeImmutable($s['dateBirth']) : null);

				$ins->subjects[] = $subject;
			}
		}

		if (isset($data['administrators']) && is_array($data['administrators'])) {
			foreach ($data['administrators'] as $a) {
				$ins->administrators[] = new Administrator(
					$a['name'] ?? '',
					$a['address'] ?? ''
				);
			}
		}

		return $ins;
	}

	public function getIsir(): ?string
	{
		return $this->isir;
	}

	public function setIsir(?string $isir): void
	{
		$this->isir = $isir;
	}

	public function getCreated(): ?DateTimeImmutable
	{
		return $this->created;
	}

	public function setCreated(?DateTimeImmutable $created): void
	{
		$this->created = $created;
	}

	public function getLastChange(): ?DateTimeImmutable
	{
		return $this->lastChange;
	}

	public function setLastChange(?DateTimeImmutable $lastChange): void
	{
		$this->lastChange = $lastChange;
	}

	public function getRowId(): ?string
	{
		return $this->rowId;
	}

	public function setRowId(?string $rowId): void
	{
		$this->rowId = $rowId;
	}

	public function getOffice(): ?string
	{
		return $this->office;
	}

	public function setOffice(?string $office): void
	{
		$this->office = $office;
	}

	public function getStatus(): ?string
	{
		return $this->status;
	}

	public function setStatus(?string $status): void
	{
		$this->status = $status;
	}

	public function getDetail(): ?Detail
	{
		return $this->detail;
	}

	public function setDetail(?Detail $detail): void
	{
		$this->detail = $detail;
	}

	/**
	 * @return Subject[]
	 */
	public function getSubjects(): array
	{
		return $this->subjects;
	}

	/**
	 * @param Subject[] $subjects
	 */
	public function setSubjects(array $subjects): void
	{
		$this->subjects = $subjects;
	}

	/**
	 * @return Administrator[]
	 */
	public function getAdministrators(): array
	{
		return $this->administrators;
	}

	/**
	 * @param Administrator[] $administrators
	 */
	public function setAdministrators(array $administrators): void
	{
		$this->administrators = $administrators;
	}

	/**
	 * @return string[]
	 */
	public function getMergeRecords(): array
	{
		return $this->mergeRecords;
	}

	/**
	 * @param string[] $mergeRecords
	 */
	public function setMergeRecords(array $mergeRecords): void
	{
		$this->mergeRecords = $mergeRecords;
	}

}
