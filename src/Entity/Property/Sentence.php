<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\Property;

final class Sentence
{

	/** @var int */
	private $realtyId;

	/** @var string */
	private $sentence;

	/** @var string|null */
	private $type;

	/** @var string|null */
	private $name;

	public function __construct(int $realtyId, string $sentence, ?string $type = null, ?string $name = null)
	{
		$this->realtyId = $realtyId;
		$this->sentence = $sentence;
		$this->type     = $type;
		$this->name     = $name;
	}

	public function getRealtyId(): int
	{
		return $this->realtyId;
	}

	public function getSentence(): string
	{
		return $this->sentence;
	}

	public function getType(): ?string
	{
		return $this->type;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

}
