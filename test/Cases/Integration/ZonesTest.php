<?php


	namespace MehrItHetznerDnsApiTest\Cases\Integration;


	use DateTime;
	use MehrIt\HetznerDnsApi\Models\Record;
	use MehrIt\HetznerDnsApi\Models\ResponseZone;
	use MehrIt\HetznerDnsApi\Models\Zone;
	use MehrItHetznerDnsApiTest\Cases\IntegrationTest;
	use MehrItHetznerDnsApiTest\Helpers\RecordsHelper;
	use MehrItHetznerDnsApiTest\Helpers\ZoneHelper;

	class ZonesTest extends IntegrationTest
	{
		use RecordsHelper;
		use ZoneHelper;



		public function testCreateZone() {

			$zoneName = $this->getEnv('TEST_ZONE_NAME');

			// delete zone if already exists
			$this->deleteZoneIfExists($zoneName);


			$response = $this->makeClient()->createZone(
				(new Zone())
					->name($zoneName)
					->ttl(86400)
			);

			$this->assertSame(86400, $response->getZone()->getTtl());
			$this->assertSame($zoneName, $response->getZone()->getName());
			$this->assertNotEmpty($response->getZone()->getId());
			$this->assertNotEmpty($response->getZone()->getNs());
			$this->assertSame(ResponseZone::STATUS_VERIFIED, $response->getZone()->getStatus());
			$this->assertGreaterThan(time() - 30, $response->getZone()->getCreated()->getTimestamp());
			$this->assertLessThan(time() + 30, $response->getZone()->getCreated()->getTimestamp());
			$this->assertGreaterThan(time() - 30, $response->getZone()->getModified()->getTimestamp());
			$this->assertLessThan(time() + 30, $response->getZone()->getModified()->getTimestamp());
		}

		public function testUpdateZone() {

			$zoneName = $this->getEnv('TEST_ZONE_NAME');

			// create zone
			$zoneId = $this->createZone($zoneName);

			$ttl = rand(0, 86399);

			$response = $this->makeClient()->updateZone(
				$zoneId,
				(new Zone())
					->name($zoneName)
					->ttl($ttl)
			);

			$this->assertSame($ttl, $response->getZone()->getTtl());
			$this->assertSame($zoneName, $response->getZone()->getName());
			$this->assertSame($zoneId, $response->getZone()->getId());
			$this->assertNotEmpty($response->getZone()->getNs());
			$this->assertSame(ResponseZone::STATUS_VERIFIED, $response->getZone()->getStatus());
			$this->assertGreaterThan(time() - 30, $response->getZone()->getCreated()->getTimestamp());
			$this->assertLessThan(time() + 30, $response->getZone()->getCreated()->getTimestamp());
			$this->assertGreaterThan(time() - 30, $response->getZone()->getModified()->getTimestamp());
			$this->assertLessThan(time() + 30, $response->getZone()->getModified()->getTimestamp());
		}

		public function testDeleteZone() {

			$zoneName = $this->getEnv('TEST_ZONE_NAME');

			// create zone
			$zoneId = $this->createZone($zoneName);

			$this->makeClient()->deleteZone($zoneId);

			$this->assertSame(null, $this->fetchZoneId($zoneName));
		}

		public function testGetZone() {

			$zoneName = $this->getEnv('TEST_ZONE_NAME');

			// create zone
			$zoneId = $this->createZone($zoneName);

			$response = $this->makeClient()->getZone($zoneId);


			$this->assertIsInt($response->getZone()->getTtl());
			$this->assertSame($zoneName, $response->getZone()->getName());
			$this->assertSame($zoneId, $response->getZone()->getId());
			$this->assertNotEmpty($response->getZone()->getNs());
			$this->assertSame(ResponseZone::STATUS_VERIFIED, $response->getZone()->getStatus());
			$this->assertGreaterThan(time() - 30, $response->getZone()->getCreated()->getTimestamp());
			$this->assertLessThan(time() + 30, $response->getZone()->getCreated()->getTimestamp());
			$this->assertGreaterThan(time() - 30, $response->getZone()->getModified()->getTimestamp());
			$this->assertLessThan(time() + 30, $response->getZone()->getModified()->getTimestamp());
		}

		public function testGetAllZones() {

			$zoneName = $this->getEnv('TEST_ZONE_NAME');

			// create zone
			$zoneId = $this->createZone($zoneName);

			$response = $this->makeClient()->getAllZones();

			$testZoneFound = false;

			foreach($response->getZones() as $currZone) {

				if ($currZone->getId() === $zoneId)
					$testZoneFound = true;

				$this->assertIsInt($currZone->getTtl());
				$this->assertNotEmpty($currZone->getName());
				$this->assertNotEmpty($currZone->getId());
				$this->assertNotEmpty($currZone->getNs());
				$this->assertInstanceOf(DateTime::class, $currZone->getCreated());
				$this->assertInstanceOf(DateTime::class, $currZone->getModified());

			}


			if (!$testZoneFound)
				$this->fail("The test zone with id {$zoneId} was not listed");

		}

		public function testGetAllZones_searchName() {

			$zoneName = $this->getEnv('TEST_ZONE_NAME');

			// create zone
			$zoneId = $this->createZone($zoneName);

			$response = $this->makeClient()->getAllZones(substr($zoneName, 0, 3));

			$testZoneFound = false;

			foreach($response->getZones() as $currZone) {

				if ($currZone->getId() === $zoneId)
					$testZoneFound = true;

				$this->assertIsInt($currZone->getTtl());
				$this->assertNotEmpty($currZone->getName());
				$this->assertNotEmpty($currZone->getId());
				$this->assertNotEmpty($currZone->getNs());
				$this->assertInstanceOf(DateTime::class, $currZone->getCreated());
				$this->assertInstanceOf(DateTime::class, $currZone->getModified());

			}


			if (!$testZoneFound)
				$this->fail("The test zone with id {$zoneId} was not listed");

		}

		public function testGetAllZones_paginated() {

			$zoneName1 = $this->getEnv('TEST_ZONE_NAME');
			$zoneName2 = $this->getEnv('TEST_ZONE2_NAME');

			// create zones
			$zoneId1 = $this->createZone($zoneName2);
			$zoneId2 = $this->createZone($zoneName1);

			// first page
			$testZone1Found = false;
			$testZone2Found = false;

			$page = 1;

			do {
				$response = $this->makeClient()->getAllZones(null, $page, 1);
				foreach ($response->getZones() as $currZone) {

					if ($currZone->getId() === $zoneId1)
						$testZone1Found = true;

					if ($currZone->getId() === $zoneId2)
						$testZone2Found = true;

				}

				$this->assertSame($page, $response->getMeta()->getPagination()->getPage());
				$this->assertSame(1, $response->getMeta()->getPagination()->getPerPage());
				$this->assertGreaterThanOrEqual(2, $response->getMeta()->getPagination()->getTotalEntries());
				$this->assertGreaterThanOrEqual(2, $response->getMeta()->getPagination()->getLastPage());

			} while ((!$testZone1Found || !$testZone2Found) && ++$page <= $response->getMeta()->getPagination()->getTotalEntries());


			if (!$testZone1Found)
				$this->fail("The test zone with id {$zoneId1} was not listed");
			if (!$testZone2Found)
				$this->fail("The test zone with id {$zoneId2} was not listed");

		}


		public function testExportZoneFile() {

			$zoneName = $this->getEnv('TEST_ZONE_NAME');

			// create zone
			$zoneId = $this->createZone($zoneName, 600);

			$this->createRecord($zoneId, '8.8.8.8', 'www', Record::TYPE_A, 900);

			$response = $this->makeClient()->exportZoneFile($zoneId);

			$this->assertStringContainsString("\$ORIGIN {$zoneName}.", $response->getPlainZoneFile());
			$this->assertStringContainsString("\$TTL 600", $response->getPlainZoneFile());
			$this->assertStringContainsString("www\t900\tIN\tA\t8.8.8.8", $response->getPlainZoneFile());

		}

		public function testImportZoneFile() {

			$zoneName = $this->getEnv('TEST_ZONE_NAME');

			// create zone
			$zoneId = $this->createZone($zoneName, 600);


			$zoneFile = implode("\n", [
				"\$ORIGIN {$zoneName}.",
				"\$TTL 600",
				"@ IN SOA ns1.first-ns.de. dns.hetzner.com. 2019112800 86400 7200 3600000 3600",
				"www\t900\tIN\tA\t8.8.8.8"
			]);


			$response = $this->makeClient()->importZoneFilePlain($zoneId, $zoneFile);

			$this->assertSame($response->getZone()->getId(), $zoneId);

			$this->assertNotNull($this->fetchRecordId($zoneId, 'www'));
		}

		public function testValidateZoneFile() {

			$this->markTestSkipped('Skipped due to bug in Hetzner API');
			
			$zoneName = $this->getEnv('TEST_ZONE_NAME');


			$zoneFile = implode("\n", [
				"\$ORIGIN {$zoneName}.",
				"\$TTL 600",
				"www\t900\tIN\tA\t8.8.8.8"
			]);


			$response = $this->makeClient()->validateZoneFilePlain($zoneFile);

			$this->assertSame('www', $response->getValidRecords()[0]->getName());
			$this->assertSame(900, $response->getValidRecords()[0]->getTtl());
			$this->assertSame('A', $response->getValidRecords()[0]->getType());
			$this->assertSame('8.8.8.8', $response->getValidRecords()[0]->getValue());

			$this->assertSame(1, $response->getParsedRecords());
		}

	}