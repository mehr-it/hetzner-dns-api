<?php


	namespace MehrItHetznerDnsApiTest\Cases\Unit\Models;


	use MehrIt\HetznerDnsApi\Models\Record;
	use MehrItHetznerDnsApiTest\Cases\TestCase;

	class RecordTest extends TestCase
	{

		public function testConstructorGetters() {

			$record = new Record();

			$this->assertSame(null, $record->getTtl());
			$this->assertSame(null, $record->getValue());
			$this->assertSame(null, $record->getName());
			$this->assertSame(null, $record->getType());
			$this->assertSame(null, $record->getZoneId());

		}

		public function testSettersAndGetters() {

			$record = new Record();

			$this->assertSame($record, $record->ttl(300));
			$this->assertSame($record, $record->value('8.8.8.8'));
			$this->assertSame($record, $record->name('www'));
			$this->assertSame($record, $record->type('A'));
			$this->assertSame($record, $record->zoneId('my-zone'));

			$this->assertSame(300, $record->getTtl());
			$this->assertSame('8.8.8.8', $record->getValue());
			$this->assertSame('www', $record->getName());
			$this->assertSame('A', $record->getType());
			$this->assertSame('my-zone', $record->getZoneId());

		}

		public function testToArray() {
			$record = new Record();

			$record->ttl(300);
			$record->value('8.8.8.8');
			$record->name('www');
			$record->type('A');
			$record->zoneId('my-zone');

			$this->assertArrayHasKeysAndValuesAssoc([
				'ttl'     => 300,
				'value'   => '8.8.8.8',
				'name'    => 'www',
				'type'    => 'A',
				'zone_id' => 'my-zone',
			], $record->toArray());
		}

		public function testJsonSerialize() {
			$record = new Record();

			$record->ttl(300);
			$record->value('8.8.8.8');
			$record->name('www');
			$record->type('A');
			$record->zoneId('my-zone');

			$this->assertArrayHasKeysAndValuesAssoc([
				'ttl'     => 300,
				'value'   => '8.8.8.8',
				'name'    => 'www',
				'type'    => 'A',
				'zone_id' => 'my-zone',
			], $record->jsonSerialize());
		}

		public function testFromArray() {
			$record = Record::fromArray([
				'ttl'     => 300,
				'value'   => '8.8.8.8',
				'name'    => 'www',
				'type'    => 'A',
				'zone_id' => 'my-zone',
			]);

			$this->assertSame(300, $record->getTtl());
			$this->assertSame('8.8.8.8', $record->getValue());
			$this->assertSame('www', $record->getName());
			$this->assertSame('A', $record->getType());
			$this->assertSame('my-zone', $record->getZoneId());


		}



	}