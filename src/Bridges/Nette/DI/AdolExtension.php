<?php declare(strict_types = 1);

namespace AsisTeam\ADOL\Bridges\Nette\DI;

use AsisTeam\ADOL\Client\Property\BuildingClient;
use AsisTeam\ADOL\Client\Property\BuildingUnitClient;
use AsisTeam\ADOL\Client\Property\LandClient;
use AsisTeam\ADOL\Client\Property\PersonClient;
use AsisTeam\ADOL\Client\WatchDogClient;
use Nette\DI\CompilerExtension;

final class AdolExtension extends CompilerExtension
{

	/** @var mixed[] */
	public $defaults = [
		// your private ADOL token
		'token'   => '',
		// see all options: http://docs.guzzlephp.org/en/stable/request-options.html
		'options' => [
			// max request time
			'timeout' => 20,
		],
	];

	/**
	 * @inheritDoc
	 */
	public function loadConfiguration(): void
	{
		$config  = $this->validateConfig($this->defaults);
		$builder = $this->getContainerBuilder();

		$params = [$config['token'], null, $config['options']];

		$builder->addDefinition($this->prefix('watchdog'))
			->setFactory(WatchDogClient::class, $params);

		$builder->addDefinition($this->prefix('property.land'))
			->setFactory(LandClient::class, $params);

		$builder->addDefinition($this->prefix('property.building'))
			->setFactory(BuildingClient::class, $params);

		$builder->addDefinition($this->prefix('property.building_unit'))
			->setFactory(BuildingUnitClient::class, $params);

		$builder->addDefinition($this->prefix('property.person'))
			->setFactory(PersonClient::class, $params);
	}

}
