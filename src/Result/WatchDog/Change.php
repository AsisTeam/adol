<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\WatchDog;

use AsisTeam\ADOL\Exception\InvalidArgumentException;
use DateTimeImmutable;

final class Change
{

	public const SUBJECT_OWNER     = 'owner';
	public const SUBJECT_RESTRICT  = 'restrict';
	public const SUBJECT_PROCEDURE = 'procedure';
	public const SUBJECT_EXISTANCE = 'existance';

	public const VALID_SUBJECTS = [
		self::SUBJECT_OWNER,
		self::SUBJECT_RESTRICT,
		self::SUBJECT_PROCEDURE,
		self::SUBJECT_EXISTANCE,
	];

	public const TYPE_ADDED   = 'added';
	public const TYPE_REMOVED = 'removed';

	public const VALID_TYPES = [
		self::TYPE_ADDED,
		self::TYPE_REMOVED,
	];

	/** @var string */
	private $name;

	/** @var string */
	private $subject;

	/** @var string */
	private $type;

	/** @var DateTimeImmutable */
	private $timeCreated;

	/** @var DateTimeImmutable */
	private $timeChange;

	public function __construct(
		string $name,
		string $subject,
		string $type,
		DateTimeImmutable $timeCreated,
		DateTimeImmutable $timeChange
	)
	{
		if (!in_array($subject, self::VALID_SUBJECTS, true)) {
			throw new InvalidArgumentException(sprintf('Invalid PropertyChange::subject "%s" given.', $subject));
		}

		if (!in_array($type, self::VALID_TYPES, true)) {
			throw new InvalidArgumentException(sprintf('Invalid PropertyChange::type "%s" given.', $type));
		}

		$this->name = $name;
		$this->subject     = $subject;
		$this->type        = $type;
		$this->timeCreated = $timeCreated;
		$this->timeChange  = $timeChange;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getSubject(): string
	{
		return $this->subject;
	}

	public function getType(): string
	{
		return $this->type;
	}

	public function getTimeCreated(): DateTimeImmutable
	{
		return $this->timeCreated;
	}

	public function getTimeChange(): DateTimeImmutable
	{
		return $this->timeChange;
	}

	/**
	 * @param mixed[] $a
	 */
	public static function fromArray(array $a): self
	{
		return new self(
			$a['name'],
			$a['subject'],
			$a['type'],
			new DateTimeImmutable($a['timeCreated']),
			new DateTimeImmutable($a['timeChange']),
		);
	}

}
