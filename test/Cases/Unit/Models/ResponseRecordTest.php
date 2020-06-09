<?php


	namespace MehrItHetznerDnsApiTest\Cases\Unit\Models;



	use DateTime;
	use DateTimeZone;
	use MehrIt\HetznerDnsApi\Models\ResponseRecord;
	use MehrItHetznerDnsApiTest\Cases\TestCase;

	class ResponseRecordTest extends TestCase
	{
		public function testConstructorGetters() {

			$record = new ResponseRecord();

			$this->assertSame(null, $record->getTtl());
			$this->assertSame(null, $record->getValue());
			$this->assertSame(null, $record->getName());
			$this->assertSame(null, $record->getType());
			$this->assertSame(null, $record->getZoneId());
			$this->assertSame(null, $record->getCreated());
			$this->assertSame(null, $record->getModified());
			$this->assertSame(null, $record->getId());

		}

		public function testSettersAndGetters() {

			$record = new ResponseRecord();

			$dtCreated = new DateTime('2020-06-02 22:32:00');
			$dtModified = new DateTime('2020-06-02 23:32:00');

			$this->assertSame($record, $record->ttl(300));
			$this->assertSame($record, $record->value('8.8.8.8'));
			$this->assertSame($record, $record->name('www'));
			$this->assertSame($record, $record->type('A'));
			$this->assertSame($record, $record->zoneId('my-zone'));
			$this->assertSame($record, $record->created($dtCreated));
			$this->assertSame($record, $record->id('my-id'));
			$this->assertSame($record, $record->modified($dtModified));

			$this->assertSame(300, $record->getTtl());
			$this->assertSame('8.8.8.8', $record->getValue());
			$this->assertSame('www', $record->getName());
			$this->assertSame('A', $record->getType());
			$this->assertSame('my-zone', $record->getZoneId());
			$this->assertSame($dtCreated, $record->getCreated());
			$this->assertSame('my-id', $record->getId());
			$this->assertSame($dtModified, $record->getModified());

		}

		public function testToArray() {
			$record = new ResponseRecord();

			$dtCreated  = new DateTime('2020-06-02 22:32:00');
			$dtModified = new DateTime('2020-06-02 23:32:00');

			$record->ttl(300);
			$record->value('8.8.8.8');
			$record->name('www');
			$record->type('A');
			$record->zoneId('my-zone');
			$record->created($dtCreated);
			$record->id('my-id');
			$record->modified($dtModified);

			$this->assertArrayHasKeysAndValuesAssoc([
				'ttl'      => 300,
				'value'    => '8.8.8.8',
				'name'     => 'www',
				'type'     => 'A',
				'zone_id'  => 'my-zone',
				'id'       => 'my-id',
				'created'  => (new DateTime('@' . $dtCreated->getTimestamp(), new DateTimeZone('UTC')))->format('Y-m-d\\TH:i:s\\Z'),
				'modified' => (new DateTime('@' . $dtModified->getTimestamp(), new DateTimeZone('UTC')))->format('Y-m-d\\TH:i:s\\Z'),
			], $record->toArray());


		}

		public function testJsonSerialize() {
			$record = new ResponseRecord();

			$dtCreated  = new DateTime('2020-06-02 22:32:00');
			$dtModified = new DateTime('2020-06-02 23:32:00');

			$record->ttl(300);
			$record->value('8.8.8.8');
			$record->name('www');
			$record->type('A');
			$record->zoneId('my-zone');
			$record->created($dtCreated);
			$record->id('my-id');
			$record->modified($dtModified);

			$this->assertArrayHasKeysAndValuesAssoc([
				'ttl'      => 300,
				'value'    => '8.8.8.8',
				'name'     => 'www',
				'type'     => 'A',
				'zone_id'  => 'my-zone',
				'id'       => 'my-id',
				'created'  => (new DateTime('@' . $dtCreated->getTimestamp(), new DateTimeZone('UTC')))->format('Y-m-d\\TH:i:s\\Z'),
				'modified' => (new DateTime('@' . $dtModified->getTimestamp(), new DateTimeZone('UTC')))->format('Y-m-d\\TH:i:s\\Z'),
			], $record->jsonSerialize());

		}

		public function testFromArray() {

			$dtCreated  = new DateTime('2020-06-02 22:32:00');
			$dtModified = new DateTime('2020-06-02 23:32:00');

			$record = ResponseRecord::fromArray([
				'ttl'      => 300,
				'value'    => '8.8.8.8',
				'name'     => 'www',
				'type'     => 'A',
				'zone_id'  => 'my-zone',
				'id'       => 'my-id',
				'created'  => (new DateTime('@' . $dtCreated->getTimestamp(), new DateTimeZone('UTC')))->format('Y-m-d\\TH:i:s\\Z'),
				'modified' => (new DateTime('@' . $dtModified->getTimestamp(), new DateTimeZone('UTC')))->format('Y-m-d\\TH:i:s\\Z'),
			]);

			$this->assertSame(300, $record->getTtl());
			$this->assertSame('8.8.8.8', $record->getValue());
			$this->assertSame('www', $record->getName());
			$this->assertSame('A', $record->getType());
			$this->assertSame('my-zone', $record->getZoneId());
			$this->assertSame('my-id', $record->getId());
			$this->assertSame($dtCreated->getTimestamp(), $record->getCreated()->getTimestamp());
			$this->assertSame($dtModified->getTimestamp(), $record->getModified()->getTimestamp());

		}
	}