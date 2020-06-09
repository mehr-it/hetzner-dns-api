<?php


	namespace MehrItHetznerDnsApiTest\Cases\Unit\Models;


	use DateTime;
	use DateTimeZone;
	use MehrIt\HetznerDnsApi\Models\ResponseZone;
	use MehrIt\HetznerDnsApi\Models\TxtVerification;
	use MehrItHetznerDnsApiTest\Cases\TestCase;
	use PHPUnit\Framework\MockObject\MockObject;

	class ResponseZoneTest extends TestCase
	{

		public function testConstructorGetters() {

			$zone = new ResponseZone();

			$this->assertSame(null, $zone->getName());
			$this->assertSame(null, $zone->getTtl());
			$this->assertSame(null, $zone->getId());
			$this->assertSame(null, $zone->getCreated());
			$this->assertSame(null, $zone->getModified());
			$this->assertSame(null, $zone->getLegacyDnsHost());
			$this->assertSame([], $zone->getLegacyNs());
			$this->assertSame([], $zone->getNs());
			$this->assertSame(null, $zone->getOwner());
			$this->assertSame(null, $zone->isPaused());
			$this->assertSame(null, $zone->getPermission());
			$this->assertSame(null, $zone->getProject());
			$this->assertSame(null, $zone->getRegistrar());
			$this->assertSame(null, $zone->getStatus());
			$this->assertSame(null, $zone->getVerified());
			$this->assertSame(null, $zone->getRecordsCount());
			$this->assertSame(null, $zone->isSecondaryDns());
			$this->assertSame(null, $zone->getTxtVerification());

		}

		public function testSettersAndGetters() {

			$zone = new ResponseZone();

			$dtCreated  = new DateTime('2020-06-02 22:32:00');
			$dtModified = new DateTime('2020-06-02 23:32:00');
			$dtVerified = new DateTime('2020-06-02 23:55:00');

			/** @var TxtVerification|MockObject $txtVerificationMock */
			$txtVerificationMock = $this->getMockBuilder(TxtVerification::class)->getMock();

			$this->assertSame($zone, $zone->name('my-name'));
			$this->assertSame($zone, $zone->ttl(300));
			$this->assertSame($zone, $zone->id('my-id'));
			$this->assertSame($zone, $zone->created($dtCreated));
			$this->assertSame($zone, $zone->modified($dtModified));
			$this->assertSame($zone, $zone->legacyDnsHost('my-host'));
			$this->assertSame($zone, $zone->legacyNs(['ln1', 'ln2']));
			$this->assertSame($zone, $zone->ns(['n1', 'n2']));
			$this->assertSame($zone, $zone->owner('me'));
			$this->assertSame($zone, $zone->paused(true));
			$this->assertSame($zone, $zone->permission('allowed'));
			$this->assertSame($zone, $zone->project('my-project'));
			$this->assertSame($zone, $zone->registrar('hetzner'));
			$this->assertSame($zone, $zone->status('verified'));
			$this->assertSame($zone, $zone->verified($dtVerified));
			$this->assertSame($zone, $zone->recordsCount(5));
			$this->assertSame($zone, $zone->secondaryDns(false));
			$this->assertSame($zone, $zone->txtVerification($txtVerificationMock));

			$this->assertSame('my-name', $zone->getName());
			$this->assertSame(300, $zone->getTtl());
			$this->assertSame('my-id', $zone->getId());
			$this->assertSame($dtCreated, $zone->getCreated());
			$this->assertSame($dtModified, $zone->getModified());
			$this->assertSame('my-host', $zone->getLegacyDnsHost());
			$this->assertSame(['ln1', 'ln2'], $zone->getLegacyNs());
			$this->assertSame(['n1', 'n2'], $zone->getNs());
			$this->assertSame('me', $zone->getOwner());
			$this->assertSame(true, $zone->isPaused());
			$this->assertSame('allowed', $zone->getPermission());
			$this->assertSame('my-project', $zone->getProject());
			$this->assertSame('hetzner', $zone->getRegistrar());
			$this->assertSame('verified', $zone->getStatus());
			$this->assertSame($dtVerified, $zone->getVerified());
			$this->assertSame(5, $zone->getRecordsCount());
			$this->assertSame(false, $zone->isSecondaryDns());
			$this->assertSame($txtVerificationMock, $zone->getTxtVerification());
		}

		public function testToArray() {
			$zone = new ResponseZone();

			$dtCreated  = new DateTime('2020-06-02 22:32:00');
			$dtModified = new DateTime('2020-06-02 23:32:00');
			$dtVerified = new DateTime('2020-06-02 23:55:00');

			/** @var TxtVerification|MockObject $txtVerificationMock */
			$txtVerificationMock = $this->getMockBuilder(TxtVerification::class)->getMock();
			$txtVerificationMock
				->method('toArray')
				->willReturn(['x' => 'array:txt']);

			$zone->name('my-name');
			$zone->ttl(300);
			$zone->id('my-id');
			$zone->created($dtCreated);
			$zone->modified($dtModified);
			$zone->legacyDnsHost('my-host');
			$zone->legacyNs(['ln1', 'ln2']);
			$zone->ns(['n1', 'n2']);
			$zone->owner('me');
			$zone->paused(true);
			$zone->permission('allowed');
			$zone->project('my-project');
			$zone->registrar('hetzner');
			$zone->status('verified');
			$zone->verified($dtVerified);
			$zone->recordsCount(5);
			$zone->secondaryDns(false);
			$zone->txtVerification($txtVerificationMock);

			$this->assertArrayHasKeysAndValuesAssoc([
				'name'             => 'my-name',
				'ttl'              => 300,
				'created'          => (new DateTime('@' . $dtCreated->getTimestamp(), new DateTimeZone('UTC')))->format('Y-m-d\\TH:i:s\\Z'),
				'modified'         => (new DateTime('@' . $dtModified->getTimestamp(), new DateTimeZone('UTC')))->format('Y-m-d\\TH:i:s\\Z'),
				'id'               => 'my-id',
				'legacy_dns_host'  => 'my-host',
				'legacy_ns'        => ['ln1', 'ln2'],
				'ns'               => ['n1', 'n2'],
				'owner'            => 'me',
				'paused'           => true,
				'permission'       => 'allowed',
				'project'          => 'my-project',
				'registrar'        => 'hetzner',
				'status'           => 'verified',
				'verified'         => (new DateTime('@' . $dtVerified->getTimestamp(), new DateTimeZone('UTC')))->format('Y-m-d\\TH:i:s\\Z'),
				'records_count'    => 5,
				'is_secondary_dns' => false,
				'txt_verification' => ['x' => 'array:txt']
			], $zone->toArray());
		}

		public function testJsonSerialize() {
			$zone = new ResponseZone();

			$dtCreated  = new DateTime('2020-06-02 22:32:00');
			$dtModified = new DateTime('2020-06-02 23:32:00');
			$dtVerified = new DateTime('2020-06-02 23:55:00');

			/** @var TxtVerification|MockObject $txtVerificationMock */
			$txtVerificationMock = $this->getMockBuilder(TxtVerification::class)->getMock();
			$txtVerificationMock
				->method('toArray')
				->willReturn(['x' => 'array:txt']);

			$zone->name('my-name');
			$zone->ttl(300);
			$zone->id('my-id');
			$zone->created($dtCreated);
			$zone->modified($dtModified);
			$zone->legacyDnsHost('my-host');
			$zone->legacyNs(['ln1', 'ln2']);
			$zone->ns(['n1', 'n2']);
			$zone->owner('me');
			$zone->paused(true);
			$zone->permission('allowed');
			$zone->project('my-project');
			$zone->registrar('hetzner');
			$zone->status('verified');
			$zone->verified($dtVerified);
			$zone->recordsCount(5);
			$zone->secondaryDns(false);
			$zone->txtVerification($txtVerificationMock);

			$this->assertArrayHasKeysAndValuesAssoc([
				'name'             => 'my-name',
				'ttl'              => 300,
				'created'          => (new DateTime('@' . $dtCreated->getTimestamp(), new DateTimeZone('UTC')))->format('Y-m-d\\TH:i:s\\Z'),
				'modified'         => (new DateTime('@' . $dtModified->getTimestamp(), new DateTimeZone('UTC')))->format('Y-m-d\\TH:i:s\\Z'),
				'id'               => 'my-id',
				'legacy_dns_host'  => 'my-host',
				'legacy_ns'        => ['ln1', 'ln2'],
				'ns'               => ['n1', 'n2'],
				'owner'            => 'me',
				'paused'           => true,
				'permission'       => 'allowed',
				'project'          => 'my-project',
				'registrar'        => 'hetzner',
				'status'           => 'verified',
				'verified'         => (new DateTime('@' . $dtVerified->getTimestamp(), new DateTimeZone('UTC')))->format('Y-m-d\\TH:i:s\\Z'),
				'records_count'    => 5,
				'is_secondary_dns' => false,
				'txt_verification' => ['x' => 'array:txt']
			], $zone->jsonSerialize());
		}

		public function testFromArray() {

			$dtCreated  = new DateTime('2020-06-02 22:32:00');
			$dtModified = new DateTime('2020-06-02 23:32:00');
			$dtVerified = new DateTime('2020-06-02 23:55:00');

			$zone = ResponseZone::fromArray([
				'name'             => 'my-name',
				'ttl'              => 300,
				'created'          => (new DateTime('@' . $dtCreated->getTimestamp(), new DateTimeZone('UTC')))->format('Y-m-d\\TH:i:s\\Z'),
				'modified'         => (new DateTime('@' . $dtModified->getTimestamp(), new DateTimeZone('UTC')))->format('Y-m-d\\TH:i:s\\Z'),
				'id'               => 'my-id',
				'legacy_dns_host'  => 'my-host',
				'legacy_ns'        => ['ln1', 'ln2'],
				'ns'               => ['n1', 'n2'],
				'owner'            => 'me',
				'paused'           => true,
				'permission'       => 'allowed',
				'project'          => 'my-project',
				'registrar'        => 'hetzner',
				'status'           => 'verified',
				'verified'         => (new DateTime('@' . $dtVerified->getTimestamp(), new DateTimeZone('UTC')))->format('Y-m-d\\TH:i:s\\Z'),
				'records_count'    => 5,
				'is_secondary_dns' => false,
				'txt_verification' => ['name' => 'nn_']
			]);

			$this->assertSame('my-name', $zone->getName());
			$this->assertSame(300, $zone->getTtl());
			$this->assertSame('my-id', $zone->getId());
			$this->assertSame($dtCreated->getTimestamp(), $zone->getCreated()->getTimestamp());
			$this->assertSame($dtModified->getTimestamp(), $zone->getModified()->getTimestamp());
			$this->assertSame('my-host', $zone->getLegacyDnsHost());
			$this->assertSame(['ln1', 'ln2'], $zone->getLegacyNs());
			$this->assertSame(['n1', 'n2'], $zone->getNs());
			$this->assertSame('me', $zone->getOwner());
			$this->assertSame(true, $zone->isPaused());
			$this->assertSame('allowed', $zone->getPermission());
			$this->assertSame('my-project', $zone->getProject());
			$this->assertSame('hetzner', $zone->getRegistrar());
			$this->assertSame('verified', $zone->getStatus());
			$this->assertSame($dtVerified->getTimestamp(), $zone->getVerified()->getTimestamp());
			$this->assertSame(5, $zone->getRecordsCount());
			$this->assertSame(false, $zone->isSecondaryDns());
			$this->assertSame('nn_', $zone->getTxtVerification()->getName());
		}

	}