<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\Property;

final class Building
{

	/** @var int */
	private $id;

	/** @var string */
	private $label;

	/** @var int */
	private $siteId;

	public function __construct(int $id, string $label, int $siteId)
	{
		$this->id     = $id;
		$this->label  = $label;
		$this->siteId = $siteId;
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getLabel(): string
	{
		return $this->label;
	}

	public function getSiteId(): int
	{
		return $this->siteId;
	}

}
