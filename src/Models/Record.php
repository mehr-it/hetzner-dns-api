<?php


	namespace MehrIt\HetznerDnsApi\Models;


	use InvalidArgumentException;

	class Record extends AbstractEntity
	{
		const TYPE_A = 'A';
		const TYPE_AAAA = 'AAAA';
		const TYPE_PTR = 'PTR';
		const TYPE_NS = 'NS';
		const TYPE_MX = 'MX';
		const TYPE_CNAME = 'CNAME';
		const TYPE_RP = 'RP';
		const TYPE_TXT = 'TXT';
		const TYPE_SOA = 'SOA';
		const TYPE_HINFO = 'HINFO';
		const TYPE_SRV = 'SRV';
		const TYPE_DANE = 'DANE';
		const TYPE_TLSA = 'TLSA';
		const TYPE_DS = 'DS';
		const TYPE_CAA = 'CAA';

		/**
		 * @inheritDoc
		 */
		public static function fromArray(array $data) {

			$model = new static();

			$model->name     = $data['name'] ?? null;
			$model->ttl      = $data['ttl'] ?? null;
			$model->type     = $data['type'] ?? null;
			$model->value    = $data['value'] ?? null;
			$model->zoneId   = $data['zone_id'] ?? null;

			return $model;
		}


		/**
		 * @var string
		 */
		protected $name;

		/**
		 * @var int
		 */
		protected $ttl;

		/**
		 * @var string
		 */
		protected $type;

		/**
		 * @var string
		 */
		protected $value;

		/**
		 * @var string
		 */
		protected $zoneId;


		/**
		 * Sets the name
		 * @param string $name The name
		 * @return $this
		 */
		public function name(string $name): Record {

			$this->name = $name;

			return $this;
		}

		/**
		 * Sets the TTL
		 * @param int $ttl The TTL in seconds
		 * @return $this
		 */
		public function ttl(int $ttl): Record {

			if ($ttl < 0)
				throw new InvalidArgumentException("DNS record TTL must not be negative, got {$ttl}");

			$this->ttl = $ttl;

			return $this;
		}

		/**
		 * Sets the record type
		 * @param string $type The record type. See TYPE_ constants, eg. TYPE_MX
 		 * @return $this
		 */
		public function type(string $type): Record {

			$this->type = $type;

			return $this;
		}

		/**
		 * Sets the record value
		 * @param string $value The record value
		 * @return $this
		 */
		public function value(string $value): Record {

			$this->value = $value;

			return $this;
		}

		/**
		 * Sets the record zone id
		 * @param string $zoneId The zone id
		 * @return $this
		 */
		public function zoneId(string $zoneId): Record {

			$this->zoneId = $zoneId;

			return $this;
		}

		/**
		 * Gets the name
		 * @return string The name
		 */
		public function getName(): ?string {
			return $this->name;
		}

		/**
		 * Gets the TTL
		 * @return int the TTL
		 */
		public function getTtl(): ?int {
			return $this->ttl;
		}

		/**
		 * Gets the record type
		 * @return string The record type
		 */
		public function getType(): ?string {
			return $this->type;
		}

		/**
		 * Gets the record value
		 * @return string The record value
		 */
		public function getValue(): ?string {
			return $this->value;
		}

		/**
		 * Gets the zone id
		 * @return string The zone id
		 */
		public function getZoneId(): ?string {
			return $this->zoneId;
		}

		/**
		 * @inheritDoc
		 */
		public function toArray(): array {

			return array_filter(
				[
					'zone_id'  => $this->zoneId,
					'type'     => $this->type,
					'name'     => $this->name,
					'value'    => $this->value,
					'ttl'      => $this->ttl,
				],
				function($v) {
					return $v !== null;
				}
			);
		}


	}