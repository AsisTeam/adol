<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\Property;

final class Sentence
{

	/** @var int */
	private $siteId;

	/** @var string */
	private $sentence;

	/** @var string|null */
	private $type;

	/** @var string|null */
	private $name;

	public function __construct(int $siteId, string $sentence, ?string $type = null, ?string $name = null)
	{
		$this->siteId   = $siteId;
		$this->sentence = $sentence;
		$this->type     = $type;
		$this->name     = $name;
	}

	public function getSiteId(): int
	{
		return $this->siteId;
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
