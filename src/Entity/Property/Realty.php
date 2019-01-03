<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Entity\Property;

abstract class Realty
{

	/** @var int */
	protected $id; //internal adol id of site/building/unit

	/** @var string */
	protected $objectLabel; // examples: parcelaCislo => 'PKN 15/1', budovaCislo => 'Č.P.1', jednotkaCislo => '192/4'

	/** @var string */
	protected $objectType; // typParcely, typStavby, typJednotky

	/** @var int */
	protected $cadastralAreaCode; // katUzemiKod

	/** @var string */
	protected $cadastralAreaName; // katUzemi

	/** @var string */
	protected $municipality; // obec

	/** @var int */
	protected $certificateOfTitle; // list vlastnictvi (LV)

	/** @var Gps */
	protected $gps;

	/** @var Sentence[]  */
	protected $sentences = [];

	/** @var Ownership[] */
	private $ownerships = [];

	public function __construct(
		int $id,
		string $objectLabel,
		string $objectType,
		int $cadastralAreaCode,
		string $cadastralAreaName,
		string $municipality,
		int $certificateOfTitle,
		Gps $gps
	)
	{
		$this->id                 = $id;
		$this->objectLabel        = $objectLabel;
		$this->objectType         = $objectType;
		$this->cadastralAreaCode  = $cadastralAreaCode;
		$this->cadastralAreaName  = $cadastralAreaName;
		$this->municipality       = $municipality;
		$this->certificateOfTitle = $certificateOfTitle;
		$this->gps                = $gps;
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getObjectLabel(): string
	{
		return $this->objectLabel;
	}

	public function getObjectType(): string
	{
		return $this->objectType;
	}

	public function getCadastralAreaCode(): int
	{
		return $this->cadastralAreaCode;
	}

	public function getCadastralAreaName(): string
	{
		return $this->cadastralAreaName;
	}

	public function getMunicipality(): string
	{
		return $this->municipality;
	}

	public function getCertificateOfTitle(): int
	{
		return $this->certificateOfTitle;
	}

	public function getGps(): Gps
	{
		return $this->gps;
	}

	/**
	 * @return Sentence[]
	 */
	public function getSentences(): array
	{
		return $this->sentences;
	}

	/**
	 * @param Sentence[] $sentences
	 */
	public function setSentences(array $sentences): void
	{
		$this->sentences = $sentences;
	}

	/**
	 * @return Ownership[]
	 */
	public function getOwnerships(): array
	{
		return $this->ownerships;
	}

	/**
	 * @param Ownership[] $ownerships
	 */
	public function setOwnerships(array $ownerships): void
	{
		$this->ownerships = $ownerships;
	}

	public function addOwnership(Ownership $o): void
	{
		$this->ownerships[] = $o;
	}

}
