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

	private ?string $latitude;

	private ?string $longitude;

	private ?array $blacklisted_countries = [];

	public function __construct($ip, ?array $countriesBlacklisted = []) {
		$infos = $this->getInfos($ip);

		$this->setBlacklistedCountries($countriesBlacklisted);

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

		$this->setLatitude($infos["latitude"] ?? null);
		$this->setLongitude($infos["longitude"] ?? null);
	}

	public function reloc($ip, ?array $coutriesBlacklisted = []): void {
		$this->__construct($ip, $coutriesBlacklisted);
	}

	/**
	 * @return array|null
	 */
	public function getBlacklistedCountries(): ?array {
		return $this->blacklisted_countries;
	}

	/**
	 * @param array|null $blacklisted_countries
	 */
	public function setBlacklistedCountries(?array $blacklisted_countries): void {
		$this->blacklisted_countries = $blacklisted_countries;
	}

	public function isBlacklisted(): bool {
		if (!in_array($this->getCountryCode(), $this->getBlacklistedCountries())) {
			if (!in_array($this->getCountry(), $this->getBlacklistedCountries())) {
				return false;
			}
		}
		return true;
	}

	/**
	 * @return string
	 */
	public function getCountry(): string {
		return $this->country;
	}

	/**
	 * @param string $country
	 */
	private function setCountry(string $country): void {
		$this->country = $country;
	}

	/**
	 * @return string
	 */
	public function getCountryCode(): string {
		return $this->countryCode;
	}

	/**
	 * @param string $country_code
	 */
	private function setCountryCode(string $country_code): void {
		$this->countryCode = $country_code;
	}

	/**
	 * @return string
	 */
	public function getRegionCode(): string {
		return $this->regionCode;
	}

	/**
	 * @param string $region_code
	 */
	private function setRegionCode(string $region_code): void {
		$this->regionCode = $region_code;
	}

	/**
	 * @return string
	 */
	public function getState(): string {
		return $this->state;
	}

	/**
	 * @param string $state
	 */
	private function setState(string $state): void {
		$this->state = $state;
	}

	/**
	 * @return string
	 */
	public function getCity(): string {
		return $this->city;
	}

	/**
	 * @param string $city
	 */
	private function setCity(string $city): void {
		$this->city = $city;
	}

	/**
	 * @return string
	 */
	public function getAddress(): string {
		return $this->address;
	}

	/**
	 * @param string $address
	 */
	private function setAddress(string $address): void {
		$this->address = $address;
	}

	/**
	 * @return bool
	 */
	public function getEuropean(): bool {
		return $this->european;
	}

	/**
	 * @param bool $european
	 */
	private function setEuropean(bool $european): void {
		$this->european = $european;
	}

	/**
	 * @return string
	 */
	public function getTimezone(): string {
		return $this->timezone;
	}

	/**
	 * @param string $timezone
	 */
	private function setTimezone(string $timezone): void {
		$this->timezone = $timezone;
	}

	/**
	 * @return string
	 */
	public function getCurrencyCode(): string {
		return $this->currencyCode;
	}

	/**
	 * @param string $currencyCode
	 */
	private function setCurrencyCode(string $currencyCode): void {
		$this->currencyCode = $currencyCode;
	}

	/**
	 * @return string
	 */
	public function getCurrencySymbol(): string {
		return $this->currencySymbol;
	}

	/**
	 * @param string $currencySymbol
	 */
	private function setCurrencySymbol(string $currencySymbol): void {
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

	/**
	 * @return string|null
	 */
	public function getLatitude(): ?string {
		return $this->latitude;
	}

	/**
	 * @param string|null $latitude
	 */
	private function setLatitude(?string $latitude): void {
		$this->latitude = $latitude;
	}

	/**
	 * @return string|null
	 */
	public function getLongitude(): ?string {
		return $this->longitude;
	}

	/**
	 * @param string|null $longitude
	 */
	private function setLongitude(?string $longitude): void {
		$this->longitude = $longitude;
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

					"european" => (boolean)@$ipdat->geoplugin_inEU,
					"timezone" => @$ipdat->geoplugin_timezone,
					"currencyCode" => @$ipdat->geoplugin_currencyCode,
					"currencySymbol" => @$ipdat->geoplugin_currencySymbol,

					"continentName" => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
					"continentCode" => @$ipdat->geoplugin_continentCode,

					"latitude" => @$ipdat->geoplugin_latitude,
					"longitude" => @$ipdat->geoplugin_longitude,
				];
			}
		}
		return $output;
	}
}