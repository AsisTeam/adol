<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Result\WatchDog;

final class Insertion
{

	/** @var string */
	private $id;

	/** @var string */
	private $warning = '';

	/** @var mixed[] */
	private $data;

	/**
	 * @param mixed[] $data
	 */
	public function __construct(string $id, string $warning, array $data)
	{
		$this->id = $id;
		$this->warning = $warning;
		$this->data = $data;
	}

	public function getId(): string
	{
		return $this->id;
	}

	public function hasWarning(): bool
	{
		return $this->warning !== '';
	}

	public function getWarning(): string
	{
		return $this->warning;
	}

	/**
	 * @return mixed[]
	 */
	public function getData(): array
	{
		return $this->data;
	}

	/**
	 * @param mixed[] $a
	 */
	public static function fromArray(array $a): self
	{
		return new self(
			$a['id'],
			$a['warningMessage'],
			$a['data']
		);
	}

}
