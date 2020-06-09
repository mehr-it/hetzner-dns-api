<?php


	namespace MehrItHetznerDnsApiTest\Cases\Unit\Models;


	use MehrIt\HetznerDnsApi\Models\Zone;
	use MehrItHetznerDnsApiTest\Cases\TestCase;

	class ZoneTest extends TestCase
	{

		public function testConstructorGetters() {

			$zone = new Zone();

			$this->assertSame(null, $zone->getName());
			$this->assertSame(null, $zone->getTtl());

		}

		public function testSettersAndGetters() {

			$zone = new Zone();

			$this->assertSame($zone, $zone->name('my-name'));
			$this->assertSame($zone, $zone->ttl(300));

			$this->assertSame('my-name', $zone->getName());
			$this->assertSame(300, $zone->getTtl());
		}

		public function testToArray() {
			$zone = new Zone();

			$zone->name('my-name');
			$zone->ttl(300);

			$this->assertArrayHasKeysAndValuesAssoc([
				'name' => 'my-name',
				'ttl' => 300,
			], $zone->toArray());
		}

		public function testJsonSerialize() {
			$zone = new Zone();

			$zone->name('my-name');
			$zone->ttl(300);

			$this->assertArrayHasKeysAndValuesAssoc([
				'name' => 'my-name',
				'ttl' => 300,
			], $zone->jsonSerialize());
		}

		public function testFromArray() {

			$zone = Zone::fromArray([
				'name' => 'my-name',
				'ttl'  => 300,
			]);

			$this->assertSame('my-name', $zone->getName());
			$this->assertSame(300, $zone->getTtl());
		}

	}