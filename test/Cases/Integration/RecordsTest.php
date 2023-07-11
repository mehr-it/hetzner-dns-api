<?php


	namespace MehrItHetznerDnsApiTest\Cases\Integration;


	use MehrIt\HetznerDnsApi\Models\Record;
	use MehrItHetznerDnsApiTest\Cases\IntegrationTest;
	use MehrItHetznerDnsApiTest\Helpers\RecordsHelper;
	use MehrItHetznerDnsApiTest\Helpers\ZoneHelper;

	class RecordsTest extends IntegrationTest
	{
		use RecordsHelper;
		use ZoneHelper;


		public function testCreateRecord() {

			$zoneName = $this->getEnv('TEST_ZONE_NAME');

			// create zone
			$zoneId = $this->createZone($zoneName);

			$response = $this->makeClient()->createRecord(
				(new Record())
					->zoneId($zoneId)
					->ttl(900)
					->type(Record::TYPE_A)
					->value('8.8.8.8')
					->name('www')
			);


			$this->assertSame($zoneId, $response->getRecord()->getZoneId());
			$this->assertSame(900, $response->getRecord()->getTtl());
			$this->assertSame(Record::TYPE_A, $response->getRecord()->getType());
			$this->assertSame('8.8.8.8', $response->getRecord()->getValue());
			$this->assertSame('www', $response->getRecord()->getName());
			$this->assertNotEmpty($response->getRecord()->getId());
			$this->assertGreaterThan(time() - 30, $response->getRecord()->getCreated()->getTimestamp());
			$this->assertLessThan(time() + 30, $response->getRecord()->getCreated()->getTimestamp());
			$this->assertGreaterThan(time() - 30, $response->getRecord()->getModified()->getTimestamp());
			$this->assertLessThan(time() + 30, $response->getRecord()->getModified()->getTimestamp());

		}

		public function testUpdateRecord() {

			$zoneName = $this->getEnv('TEST_ZONE_NAME');

			// create zone
			$zoneId = $this->createZone($zoneName);


			$recordId = $this->createRecord($zoneId, '8.8.8.8', 'mail', Record::TYPE_A, 300);

			$response = $this->makeClient()->updateRecord(
				$recordId,
				(new Record())
					->zoneId($zoneId)
					->ttl(900)
					->type(Record::TYPE_A)
					->value('1.1.1.1')
					->name('www')
			);

			$this->assertSame($zoneId, $response->getRecord()->getZoneId());
			$this->assertSame(900, $response->getRecord()->getTtl());
			$this->assertSame(Record::TYPE_A, $response->getRecord()->getType());
			$this->assertSame('1.1.1.1', $response->getRecord()->getValue());
			$this->assertSame('www', $response->getRecord()->getName());
			$this->assertSame($recordId, $response->getRecord()->getId());
			$this->assertGreaterThan(time() - 30, $response->getRecord()->getCreated()->getTimestamp());
			$this->assertLessThan(time() + 30, $response->getRecord()->getCreated()->getTimestamp());
			$this->assertGreaterThan(time() - 30, $response->getRecord()->getModified()->getTimestamp());
			$this->assertLessThan(time() + 30, $response->getRecord()->getModified()->getTimestamp());

		}

		public function testDeleteRecord() {

			$zoneName = $this->getEnv('TEST_ZONE_NAME');

			// create zone
			$zoneId = $this->createZone($zoneName);


			$recordId = $this->createRecord($zoneId, '8.8.8.8', 'mail', Record::TYPE_A, 300);

			$this->makeClient()->deleteRecord($recordId);

			$this->assertSame(null, $this->fetchRecordId($zoneId, 'mail', Record::TYPE_A));
		}

		public function testGetRecord() {
			$zoneName = $this->getEnv('TEST_ZONE_NAME');

			// create zone
			$zoneId = $this->createZone($zoneName);


			$recordId = $this->createRecord($zoneId, '8.8.8.8', 'www', Record::TYPE_A, 300);

			$response = $this->makeClient()->getRecord($recordId);

			$this->assertSame($zoneId, $response->getRecord()->getZoneId());
			$this->assertSame(300, $response->getRecord()->getTtl());
			$this->assertSame(Record::TYPE_A, $response->getRecord()->getType());
			$this->assertSame('8.8.8.8', $response->getRecord()->getValue());
			$this->assertSame('www', $response->getRecord()->getName());
			$this->assertSame($recordId, $response->getRecord()->getId());
			$this->assertGreaterThan(time() - 30, $response->getRecord()->getCreated()->getTimestamp());
			$this->assertLessThan(time() + 30, $response->getRecord()->getCreated()->getTimestamp());
			$this->assertGreaterThan(time() - 30, $response->getRecord()->getModified()->getTimestamp());
			$this->assertLessThan(time() + 30, $response->getRecord()->getModified()->getTimestamp());
		}

		public function testGetAllRecords() {
			$this->markTestSkipped('Skipped due to bug in Hetzner API');

			$zoneName = $this->getEnv('TEST_ZONE_NAME');

			// create zone
			$zoneId = $this->createZone($zoneName);


			$recordId1 = $this->createRecord($zoneId, '8.8.8.8', 'www', Record::TYPE_A, 300);
			$recordId2 = $this->createRecord($zoneId, 'mail.de', 'mail', Record::TYPE_CNAME, 900);

			$response = $this->makeClient()->getAllRecords();

			$record1Seen = false;
			$record2Seen = false;
			foreach($response->getRecords() as $currRecord) {

				if ($currRecord->getId() === $recordId1) {

					$this->assertSame($zoneId, $currRecord->getZoneId());
					$this->assertSame(300, $currRecord->getTtl());
					$this->assertSame(Record::TYPE_A, $currRecord->getType());
					$this->assertSame('8.8.8.8', $currRecord->getValue());
					$this->assertSame('www', $currRecord->getName());
					$this->assertGreaterThan(time() - 30, $currRecord->getCreated()->getTimestamp());
					$this->assertLessThan(time() + 30, $currRecord->getCreated()->getTimestamp());
					$this->assertGreaterThan(time() - 30, $currRecord->getModified()->getTimestamp());
					$this->assertLessThan(time() + 30, $currRecord->getModified()->getTimestamp());

					$record1Seen = true;
				}
				elseif ($currRecord->getId() === $recordId2) {
					$record2Seen = true;

					$this->assertSame($zoneId, $currRecord->getZoneId());
					$this->assertSame(900, $currRecord->getTtl());
					$this->assertSame(Record::TYPE_CNAME, $currRecord->getType());
					$this->assertSame('mail.de', $currRecord->getValue());
					$this->assertSame('mail', $currRecord->getName());
					$this->assertGreaterThan(time() - 30, $currRecord->getCreated()->getTimestamp());
					$this->assertLessThan(time() + 30, $currRecord->getCreated()->getTimestamp());
					$this->assertGreaterThan(time() - 30, $currRecord->getModified()->getTimestamp());
					$this->assertLessThan(time() + 30, $currRecord->getModified()->getTimestamp());
				}

			}

			$this->assertSame(true, $record1Seen);
			$this->assertSame(true, $record2Seen);

		}

		public function testGetAllRecords_withZoneId() {
			$zoneName = $this->getEnv('TEST_ZONE_NAME');

			// create zone
			$zoneId = $this->createZone($zoneName);


			$recordId1 = $this->createRecord($zoneId, '8.8.8.8', 'www', Record::TYPE_A, 300);
			$recordId2 = $this->createRecord($zoneId, 'mail.de', 'mail', Record::TYPE_CNAME, 900);

			$response = $this->makeClient()->getAllRecords($zoneId);

			$record1Seen = false;
			$record2Seen = false;
			foreach($response->getRecords() as $currRecord) {

				if ($currRecord->getId() === $recordId1) {

					$this->assertSame($zoneId, $currRecord->getZoneId());
					$this->assertSame(300, $currRecord->getTtl());
					$this->assertSame(Record::TYPE_A, $currRecord->getType());
					$this->assertSame('8.8.8.8', $currRecord->getValue());
					$this->assertSame('www', $currRecord->getName());
					$this->assertGreaterThan(time() - 30, $currRecord->getCreated()->getTimestamp());
					$this->assertLessThan(time() + 30, $currRecord->getCreated()->getTimestamp());
					$this->assertGreaterThan(time() - 30, $currRecord->getModified()->getTimestamp());
					$this->assertLessThan(time() + 30, $currRecord->getModified()->getTimestamp());

					$record1Seen = true;
				}
				elseif ($currRecord->getId() === $recordId2) {
					$record2Seen = true;

					$this->assertSame($zoneId, $currRecord->getZoneId());
					$this->assertSame(900, $currRecord->getTtl());
					$this->assertSame(Record::TYPE_CNAME, $currRecord->getType());
					$this->assertSame('mail.de', $currRecord->getValue());
					$this->assertSame('mail', $currRecord->getName());
					$this->assertGreaterThan(time() - 30, $currRecord->getCreated()->getTimestamp());
					$this->assertLessThan(time() + 30, $currRecord->getCreated()->getTimestamp());
					$this->assertGreaterThan(time() - 30, $currRecord->getModified()->getTimestamp());
					$this->assertLessThan(time() + 30, $currRecord->getModified()->getTimestamp());
				}

				$this->assertSame($zoneId, $currRecord->getZoneId());

			}

			$this->assertSame(true, $record1Seen);
			$this->assertSame(true, $record2Seen);

		}

		public function testGetAllRecords_paginated() {

			$this->markTestSkipped('Skipped due to bug in Hetzner API');

			$zoneName = $this->getEnv('TEST_ZONE_NAME');

			// create zone
			$zoneId = $this->createZone($zoneName);


			$recordId1 = $this->createRecord($zoneId, '8.8.8.8', 'www', Record::TYPE_A, 300);
			$recordId2 = $this->createRecord($zoneId, 'mail.de', 'mail', Record::TYPE_CNAME, 900);


			$record1Seen = false;
			$record2Seen = false;

			$page = 1;
			do {
				$response = $this->makeClient()->getAllRecords($zoneId, 2, $page);

				foreach($response->getRecords() as $currRecord) {

					if ($currRecord->getId() === $recordId1) {

						$this->assertSame($zoneId, $currRecord->getZoneId());
						$this->assertSame(300, $currRecord->getTtl());
						$this->assertSame(Record::TYPE_A, $currRecord->getType());
						$this->assertSame('8.8.8.8', $currRecord->getValue());
						$this->assertSame('www', $currRecord->getName());
						$this->assertGreaterThan(time() - 30, $currRecord->getCreated()->getTimestamp());
						$this->assertLessThan(time() + 30, $currRecord->getCreated()->getTimestamp());
						$this->assertGreaterThan(time() - 30, $currRecord->getModified()->getTimestamp());
						$this->assertLessThan(time() + 30, $currRecord->getModified()->getTimestamp());

						$record1Seen = true;
					}
					elseif ($currRecord->getId() === $recordId2) {
						$record2Seen = true;

						$this->assertSame($zoneId, $currRecord->getZoneId());
						$this->assertSame(900, $currRecord->getTtl());
						$this->assertSame(Record::TYPE_CNAME, $currRecord->getType());
						$this->assertSame('mail.de', $currRecord->getValue());
						$this->assertSame('mail', $currRecord->getName());
						$this->assertGreaterThan(time() - 30, $currRecord->getCreated()->getTimestamp());
						$this->assertLessThan(time() + 30, $currRecord->getCreated()->getTimestamp());
						$this->assertGreaterThan(time() - 30, $currRecord->getModified()->getTimestamp());
						$this->assertLessThan(time() + 30, $currRecord->getModified()->getTimestamp());
					}

					$this->assertSame($page, $response->getMeta()->getPagination()->getPage());
					$this->assertSame(1, $response->getMeta()->getPagination()->getPerPage());
					$this->assertGreaterThanOrEqual(2, $response->getMeta()->getPagination()->getTotalEntries());
					$this->assertGreaterThanOrEqual(2, $response->getMeta()->getPagination()->getLastPage());

				}
			} while ((!$record1Seen || !$record2Seen) && ++$page <= $response->getMeta()->getPagination()->getTotalEntries());

			$this->assertSame(true, $record1Seen);
			$this->assertSame(true, $record2Seen);

		}


		public function testBulkCreateRecords() {

			$zoneName = $this->getEnv('TEST_ZONE_NAME');

			// create zone
			$zoneId = $this->createZone($zoneName);

			$response = $this->makeClient()->bulkCreateRecords([
				(new Record())
					->zoneId($zoneId)
					->ttl(900)
					->type(Record::TYPE_A)
					->value('8.8.8.8')
					->name('www'),
				(new Record())
					->zoneId($zoneId)
					->ttl(300)
					->type(Record::TYPE_A)
					->value('1.1.1.1')
					->name('mail'),
			]);


			$this->assertSame($zoneId, $response->getRecords()[0]->getZoneId());
			$this->assertSame(900, $response->getRecords()[0]->getTtl());
			$this->assertSame(Record::TYPE_A, $response->getRecords()[0]->getType());
			$this->assertSame('8.8.8.8', $response->getRecords()[0]->getValue());
			$this->assertSame('www', $response->getRecords()[0]->getName());
			$this->assertNotEmpty($response->getRecords()[0]->getId());
			$this->assertGreaterThan(time() - 30, $response->getRecords()[0]->getCreated()->getTimestamp());
			$this->assertLessThan(time() + 30, $response->getRecords()[0]->getCreated()->getTimestamp());
			$this->assertGreaterThan(time() - 30, $response->getRecords()[0]->getModified()->getTimestamp());
			$this->assertLessThan(time() + 30, $response->getRecords()[0]->getModified()->getTimestamp());

			$this->assertSame($zoneId, $response->getRecords()[1]->getZoneId());
			$this->assertSame(300, $response->getRecords()[1]->getTtl());
			$this->assertSame(Record::TYPE_A, $response->getRecords()[1]->getType());
			$this->assertSame('1.1.1.1', $response->getRecords()[1]->getValue());
			$this->assertSame('mail', $response->getRecords()[1]->getName());
			$this->assertNotEmpty($response->getRecords()[1]->getId());
			$this->assertGreaterThan(time() - 30, $response->getRecords()[1]->getCreated()->getTimestamp());
			$this->assertLessThan(time() + 30, $response->getRecords()[1]->getCreated()->getTimestamp());
			$this->assertGreaterThan(time() - 30, $response->getRecords()[1]->getModified()->getTimestamp());
			$this->assertLessThan(time() + 30, $response->getRecords()[1]->getModified()->getTimestamp());

		}

		public function testBulkUpdateRecords() {

			$this->markTestSkipped('Skipped due to bug in Hetzner API');

			$zoneName = $this->getEnv('TEST_ZONE_NAME');

			// create zone
			$zoneId = $this->createZone($zoneName);

			$recordId1 = $this->createRecord($zoneId, 'www.de', 'www', Record::TYPE_CNAME, 300);
			$recordId2 = $this->createRecord($zoneId, 'mail.de', 'mail', Record::TYPE_CNAME, 900);


			$response = $this->makeClient()->bulkUpdateRecords([
				(new Record())
					->zoneId($zoneId)
					->ttl(400)
					->type(Record::TYPE_CNAME)
					->value('1www.de')
					->name('www'),
				(new Record())
					->zoneId($zoneId)
					->ttl(600)
					->type(Record::TYPE_CNAME)
					->value('1mail.de')
					->name('mail'),
			]);


			$this->assertSame($zoneId, $response->getRecords()[0]->getZoneId());
			$this->assertSame(400, $response->getRecords()[0]->getTtl());
			$this->assertSame(Record::TYPE_CNAME, $response->getRecords()[0]->getType());
			$this->assertSame('1www.de', $response->getRecords()[0]->getValue());
			$this->assertSame('www', $response->getRecords()[0]->getName());
			$this->assertNotEmpty($response->getRecords()[0]->getId());
			$this->assertGreaterThan(time() - 30, $response->getRecords()[0]->getCreated()->getTimestamp());
			$this->assertLessThan(time() + 30, $response->getRecords()[0]->getCreated()->getTimestamp());
			$this->assertGreaterThan(time() - 30, $response->getRecords()[0]->getModified()->getTimestamp());
			$this->assertLessThan(time() + 30, $response->getRecords()[0]->getModified()->getTimestamp());

			$this->assertSame($zoneId, $response->getRecords()[1]->getZoneId());
			$this->assertSame(600, $response->getRecords()[1]->getTtl());
			$this->assertSame(Record::TYPE_CNAME, $response->getRecords()[1]->getType());
			$this->assertSame('1mail.de', $response->getRecords()[1]->getValue());
			$this->assertSame('mail', $response->getRecords()[1]->getName());
			$this->assertNotEmpty($response->getRecords()[1]->getId());
			$this->assertGreaterThan(time() - 30, $response->getRecords()[1]->getCreated()->getTimestamp());
			$this->assertLessThan(time() + 30, $response->getRecords()[1]->getCreated()->getTimestamp());
			$this->assertGreaterThan(time() - 30, $response->getRecords()[1]->getModified()->getTimestamp());
			$this->assertLessThan(time() + 30, $response->getRecords()[1]->getModified()->getTimestamp());

		}

	}
