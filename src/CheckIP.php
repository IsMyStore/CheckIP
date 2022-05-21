<?php

namespace ismystore\checkip;

class CheckIP {

	public ?string $country;
	public ?string $country_code;
	public ?string $region_code;
	public ?string $state;
	public ?string $city;
	public ?string $address;

	public ?bool $european;
	public ?string $timezone;
	public ?string $currencyCode;
	public ?string $currencySymbol;

	public function __construct($ip) {
		$this->setCountry($this->getInfos($ip, "Country"));
		$this->setCountryCode($this->getInfos($ip, "Country Code"));
		$this->setRegionCode($this->getInfos($ip, "Region Code"));
		$this->setState($this->getInfos($ip, "State"));
		$this->setCity($this->getInfos($ip, "City"));
		$this->setAddress($this->getInfos($ip, "Address"));

		$this->setEuropean($this->getinfos($ip, "European"));
		$this->setTimezone($this->getInfos($ip, "Timezone"));
		$this->setCurrencyCode($this->getInfos($ip, "Currency Code"));
		$this->setCurrencySymbol($this->getInfos($ip,"Currency Symbol"));
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
	public function setCountry(array|string|null $country): void {
		$this->country = $country;
	}

	/**
	 * @return array|string|null
	 */
	public function getCountryCode(): array|string|null {
		return $this->country_code;
	}

	/**
	 * @param array|string|null $country_code
	 */
	public function setCountryCode(array|string|null $country_code): void {
		$this->country_code = $country_code;
	}

	/**
	 * @return array|string|null
	 */
	public function getRegionCode(): array|string|null {
		return $this->region_code;
	}

	/**
	 * @param array|string|null $region_code
	 */
	public function setRegionCode(array|string|null $region_code): void {
		$this->region_code = $region_code;
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
	public function setState(array|string|null $state): void {
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
	public function setCity(array|string|null $city): void {
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
	public function setAddress(array|string|null $address): void {
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
	public function setEuropean(bool|array|string|null $european): void {
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
	public function setTimezone(array|string|null $timezone): void {
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
	public function setCurrencyCode(array|string|null $currencyCode): void {
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
	public function setCurrencySymbol(array|string|null $currencySymbol): void {
		$this->currencySymbol = $currencySymbol;
	}

	private function getInfos($ip, string $toGet = "location"): array|string|null {
		$output = NULL;
		if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
			$ip = $_SERVER["REMOTE_ADDR"];
		}
		$purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($toGet)));
		$support = array("location", "address", "city", "region", "state", "region_code", "country","countrycode", "european", "timezone", "currencyCode", "currencySymbol");
		$continents = array(
			"AF" => "Africa",
			"AN" => "Antarctica",
			"AS" => "Asia",
			"EU" => "Europe",
			"OC" => "Australia (Oceania)",
			"NA" => "North America",
			"SA" => "South America"
		);
		if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
			$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));

			if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
				switch ($purpose) {
					case "address":
						$address = array($ipdat->geoplugin_countryName);
						if (@strlen($ipdat->geoplugin_regionName) >= 1)
							$address[] = $ipdat->geoplugin_regionName;
						if (@strlen($ipdat->geoplugin_city) >= 1)
							$address[] = $ipdat->geoplugin_city;
						$output = implode(", ", array_reverse($address));
						break;
					case "city":
						$output = @$ipdat->geoplugin_city;
						break;
					case "region":
					case "state":
						$output = @$ipdat->geoplugin_regionName;
						break;
					case "region_code":
						$output = @$ipdat->geoplugin_regionCode;
						break;
					case "country":
						$output = @$ipdat->geoplugin_countryName;
						break;
					case "countrycode":
						$output = @$ipdat->geoplugin_countryCode;
						break;
					case "european":
						$output = (bool)@$ipdat->geoplugin_inEU;
						break;
					case "timezone":
						$output = @$ipdat->geoplugin_timezone;
						break;
					case "currencyCode":
						$output = @$ipdat->geoplugin_currencyCode;
						break;
					case "currencySymbol":
						$output = @$ipdat->geoplugin_currencySymbol;
						break;
				}
			}
		}
		return $output;
	}
}