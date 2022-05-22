<?php

namespace ismystore\checkip;

class CheckIP {

	private ?string $country;

	private ?string $countryCode;

	private ?string $regionCode;

	private ?string $state;

	private ?string $city;

	private ?string $address;

	private ?bool $european;

	private ?string $timezone;

	private ?string $currencyCode;

	private ?string $currencySymbol;

	private ?string $continentName;

	private ?string $continentCode;

	public function __construct($ip) {

		$infos = $this->getInfos($ip);

		$this->setCountry($infos["country"] ?? null);
		$this->setCountryCode($infos["countryCode"] ?? null);
		$this->setRegionCode($infos["regionCode"] ?? null);
		$this->setState($infos["state"] ?? null);
		$this->setCity($infos["city"] ?? null);
		$this->setAddress($infos["address"] ?? null);

		$this->setEuropean($infos["european"] ?? false);
		$this->setTimezone($infos["timezone"] ?? date_default_timezone_get());
		$this->setCurrencyCode($infos["currencyCode"] ?? "USD");
		$this->setCurrencySymbol($infos["currencySymbol"] ?? "$");

		$this->setContinentName($infos["continentName"] ?? null);
		$this->setContinentCode($infos["continentCode"] ?? null);
	}

	/**
	 * @return array|string|null
	 */
	public function getCountry(): array|string|null {
		return $this->country;
	}

	/**
	 * @param array|string|null $country
	 */
	private function setCountry(array|string|null $country): void {
		$this->country = $country;
	}

	/**
	 * @return array|string|null
	 */
	public function getCountryCode(): array|string|null {
		return $this->countryCode;
	}

	/**
	 * @param array|string|null $country_code
	 */
	private function setCountryCode(array|string|null $country_code): void {
		$this->countryCode = $country_code;
	}

	/**
	 * @return array|string|null
	 */
	public function getRegionCode(): array|string|null {
		return $this->regionCode;
	}

	/**
	 * @param array|string|null $region_code
	 */
	private function setRegionCode(array|string|null $region_code): void {
		$this->regionCode = $region_code;
	}

	/**
	 * @return array|string|null
	 */
	public function getState(): array|string|null {
		return $this->state;
	}

	/**
	 * @param array|string|null $state
	 */
	private function setState(array|string|null $state): void {
		$this->state = $state;
	}

	/**
	 * @return array|string|null
	 */
	public function getCity(): array|string|null {
		return $this->city;
	}

	/**
	 * @param array|string|null $city
	 */
	private function setCity(array|string|null $city): void {
		$this->city = $city;
	}

	/**
	 * @return array|string|null
	 */
	public function getAddress(): array|string|null {
		return $this->address;
	}

	/**
	 * @param array|string|null $address
	 */
	private function setAddress(array|string|null $address): void {
		$this->address = $address;
	}

	/**
	 * @return array|bool|string|null
	 */
	public function getEuropean(): bool|array|string|null {
		return $this->european;
	}

	/**
	 * @param array|bool|string|null $european
	 */
	private function setEuropean(bool|array|string|null $european): void {
		$this->european = $european;
	}

	/**
	 * @return array|string|null
	 */
	public function getTimezone(): array|string|null {
		return $this->timezone;
	}

	/**
	 * @param array|string|null $timezone
	 */
	private function setTimezone(array|string|null $timezone): void {
		$this->timezone = $timezone;
	}

	/**
	 * @return array|string|null
	 */
	public function getCurrencyCode(): array|string|null {
		return $this->currencyCode;
	}

	/**
	 * @param array|string|null $currencyCode
	 */
	private function setCurrencyCode(array|string|null $currencyCode): void {
		$this->currencyCode = $currencyCode;
	}

	/**
	 * @return array|string|null
	 */
	public function getCurrencySymbol(): array|string|null {
		return $this->currencySymbol;
	}

	/**
	 * @param array|string|null $currencySymbol
	 */
	private function setCurrencySymbol(array|string|null $currencySymbol): void {
		$this->currencySymbol = $currencySymbol;
	}

	/**
	 * @return string|null
	 */
	public function getContinentName(): ?string {
		return $this->continentName;
	}

	/**
	 * @param string|null $continentName
	 */
	private function setContinentName(?string $continentName): void {
		$this->continentName = $continentName;
	}

	/**
	 * @return string|null
	 */
	public function getContinentCode(): ?string {
		return $this->continentCode;
	}

	/**
	 * @param string|null $continentCode
	 */
	private function setContinentCode(?string $continentCode): void {
		$this->continentCode = $continentCode;
	}

	private function getInfos($ip): array|string|null {
		$output = NULL;
		if (!$ip or filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
			$ip = $_SERVER["REMOTE_ADDR"];
		}

		$continents = array(
			"AF" => "Africa",
			"AN" => "Antarctica",
			"AS" => "Asia",
			"EU" => "Europe",
			"OC" => "Australia (Oceania)",
			"NA" => "North America",
			"SA" => "South America"
		);

		if (filter_var($ip, FILTER_VALIDATE_IP)) {
			$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));

			if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
				$address = array($ipdat->geoplugin_countryName);
				if (@strlen($ipdat->geoplugin_regionName) >= 1)
					$address[] = $ipdat->geoplugin_regionName;
				if (@strlen($ipdat->geoplugin_city) >= 1)
					$address[] = $ipdat->geoplugin_city;
				$outputAddress = implode(", ", array_reverse($address));

				$output = [
					"country" => @$ipdat->geoplugin_countryName,
					"countryCode" => @$ipdat->geoplugin_countryCode,
					"regionCode" => @$ipdat->geoplugin_regionCode,
					"state" => @$ipdat->geoplugin_regionName,
					"city" => @$ipdat->geoplugin_city,
					"address" => $outputAddress,

					"european" => @$ipdat->geoplugin_european,
					"timezone" => @$ipdat->geoplugin_timezone,
					"currencyCode" => @$ipdat->geoplugin_currencyCode,
					"currencySymbol" => @$ipdat->geoplugin_currencySymbol,

					"continentName" => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
					"continentCode" => @$ipdat->geoplugin_continentCode,
				];
			}
		}
		return $output;
	}
}