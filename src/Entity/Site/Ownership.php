<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\Site;

final class Ownership
{

	/** @var int */
	private $siteId;

	/** @var Owner */
	private $owner;

	/** @var string */
	private $share;

	/** @var string */
	private $rightsType;

	/** @var string|null */
	private $name;

	public function __construct(int $siteId, Owner $owner, string $share, string $rightsType, ?string $name = null)
	{
		$this->siteId     = $siteId;
		$this->owner      = $owner;
		$this->share      = $share;
		$this->rightsType = $rightsType;
		$this->name       = $name;
	}

	public function getSiteId(): int
	{
		return $this->siteId;
	}

	public function getOwner(): Owner
	{
		return $this->owner;
	}

	public function getShare(): string
	{
		return $this->share;
	}

	public function getRightsType(): string
	{
		return $this->rightsType;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

}
