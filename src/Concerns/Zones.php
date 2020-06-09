<?php


	namespace MehrIt\HetznerDnsApi\Concerns;


	use InvalidArgumentException;
	use MehrIt\HetznerDnsApi\Models\Response\ZoneExportResponse;
	use MehrIt\HetznerDnsApi\Models\Response\ZoneResponse;
	use MehrIt\HetznerDnsApi\Models\Response\ZonesPaginatedResponse;
	use MehrIt\HetznerDnsApi\Models\Response\ZoneValidateResponse;
	use MehrIt\HetznerDnsApi\Models\Zone;

	trait Zones
	{

		/**
		 * Returns an object containing all information about a zone
		 * @param string $zoneId The zone id
		 * @return ZoneResponse
		 */
		public function getZone(string $zoneId): ZoneResponse {

			return ZoneResponse::create(
				$this->request('GET', 'zones/' . urlencode($zoneId))
			);

		}

		/**
		 * Updates a zone
		 * @param string $zoneId The zone id
		 * @param Zone $zone The zone
		 * @return ZoneResponse
		 */
		public function updateZone(string $zoneId, Zone $zone): ZoneResponse {

			return ZoneResponse::create(
				$this->request('PUT', 'zones/' . urlencode($zoneId), [
					'json' => $zone,
				])
			);
		}

		/**
		 * Delete a zone
		 * @param string $zoneId The zone id
		 */
		public function deleteZone(string $zoneId): void {
			$this->request('DELETE', 'zones/' . urlencode($zoneId));
		}

		/**
		 * Creates a new zone
		 * @param Zone $zone The zone
		 * @return ZoneResponse
		 */
		public function createZone(Zone $zone): ZoneResponse {
			return ZoneResponse::create(
				$this->request('POST', 'zones', [
					'json' => $zone,
				])
			);
		}


		/**
		 * Gets a zone by it's name. This method uses the name parameter for exact search with "Get all zones" operation. See @link https://dns.hetzner.com/api-docs/#operation/GetZones
		 * @param string $name The name
		 * @return ZonesPaginatedResponse
		 */
		public function getZoneByName(string $name): ZonesPaginatedResponse {

			return ZonesPaginatedResponse::create(
				$this->request('GET', 'zones', [
					'query' => [
						'name' => $name,
					],
				])
			);

		}

		/**
		 * Gets all zones
		 * @param string|null $searchName Partial name of a zone. If given, only zones containing this string are returned.
		 * @param int $perPage The number of records per page
		 * @param int $page The page number
		 * @return ZonesPaginatedResponse
		 */
		public function getAllZones(string $searchName = null, int $page = 1, int $perPage = 100): ZonesPaginatedResponse {

			if ($perPage < 1 || $perPage > 100)
				throw new InvalidArgumentException('PerPage must be between 1 and 100');
			if ($page < 1)
				throw new InvalidArgumentException('Page must be greater than 0');

			$query = [];

			if ($searchName !== null && $searchName !== '')
				$query['searchName'] = $searchName;
			if ($perPage != 100)
				$query['per_page'] = $perPage;
			if ($page != 1)
				$query['page'] = $page;

			return ZonesPaginatedResponse::create(
				$this->request('GET', 'zones', [
					'query' => $query,
				])
			);

		}

		/**
		 * Import a zone file in text/plain format
		 * @param string $zoneId The zone id
		 * @param string $zoneFileContent The zone file content
		 * @return ZoneResponse
		 */
		public function importZoneFilePlain(string $zoneId, string $zoneFileContent): ZoneResponse {
			return ZoneResponse::create(
				$this->request('POST', 'zones/' . urlencode($zoneId) . '/import', [
					'body' => $zoneFileContent,
					'headers' => [
						'Content-Type' => 'text/plain',
					],
				])
			);
		}

		/**
		 * Exports a zone file
		 * @param string $zoneId The zone id
		 * @return ZoneExportResponse
		 */
		public function exportZoneFile(string $zoneId): ZoneExportResponse {
			return ZoneExportResponse::create(
				$this->request('GET', 'zones/' . urlencode($zoneId) . '/export')
			);
		}

		/**
		 * Validate a zone file in text/plain format
		 * @param string $zoneFileContent The zone file content
		 * @return ZoneValidateResponse
		 */
		public function validateZoneFilePlain(string $zoneFileContent): ZoneValidateResponse {
			return ZoneValidateResponse::create(
				$this->request('POST', 'zones/file/validate', [
					'body'    => $zoneFileContent,
					'headers' => [
						'Content-Type' => 'text/plain',
					],
				])
			);
		}
	}