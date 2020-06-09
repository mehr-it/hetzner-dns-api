<?php


	namespace MehrItHetznerDnsApiTest\Cases\Unit\Models;


	use MehrIt\HetznerDnsApi\Models\TxtVerification;
	use MehrItHetznerDnsApiTest\Cases\TestCase;

	class TxtVerificationTest extends TestCase
	{

		public function testConstructorGetters() {

			$txt = new TxtVerification();

			$this->assertSame(null, $txt->getName());
			$this->assertSame(null, $txt->getToken());

		}

		public function testSettersAndGetters() {
			$txt = new TxtVerification();

			$this->assertSame($txt, $txt->name('my-name'));
			$this->assertSame($txt, $txt->token('my-token'));

			$this->assertSame('my-name', $txt->getName());
			$this->assertSame('my-token', $txt->getToken());
		}

		public function testToArray() {

			$txt = new TxtVerification();

			$txt->name('my-name');
			$txt->token('my-token');

			$this->assertArrayHasKeysAndValuesAssoc([
				'name' => 'my-name',
				'token' => 'my-token',
			], $txt->toArray());
		}

		public function testJsonSerialize() {

			$txt = new TxtVerification();

			$txt->name('my-name');
			$txt->token('my-token');

			$this->assertArrayHasKeysAndValuesAssoc([
				'name'  => 'my-name',
				'token' => 'my-token',
			], $txt->jsonSerialize());
		}

		public function testFromArray() {

			$txt = TxtVerification::fromArray([
				'name'  => 'my-name',
				'token' => 'my-token',
			]);

			$this->assertSame('my-name', $txt->getName());
			$this->assertSame('my-token', $txt->getToken());
		}

	}