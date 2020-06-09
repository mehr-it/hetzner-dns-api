<?php


	namespace MehrIt\HetznerDnsApi\Models;


	class Zone extends AbstractEntity
	{
		/**
		 * @inheritDoc
		 */
		public static function fromArray(array $data) {

			$model = new static();

			$model->name = $data['name'] ?? null;
			$model->ttl  = $data['ttl'] ?? null;

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
		 * Sets the zone name
		 * @param string $name The zone name
		 * @return $this
		 */
		public function name(string $name): Zone {
			$this->name = $name;

			return $this;
		}

		/**
		 * Sets the TTL
		 * @param int $ttl The TTL
		 * @return $this
		 */
		public function ttl(int $ttl): Zone {

			if ($ttl < 0)
				throw new \InvalidArgumentException('TTL must not be negative');

			$this->ttl = $ttl;

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
		 * @return int The TTL
		 */
		public function getTtl(): ?int {
			return $this->ttl;
		}


		/**
		 * @inheritDoc
		 */
		public function toArray(): array {

			return array_filter(
				[
					'name' => $this->name,
					'ttl'  => $this->ttl,
				],
				function ($v) {

					if (is_array($v))
						return array_filter($v, function ($v) {
								return $v !== null;
							}) !== [];
					else
						return $v !== null;
				}
			);
		}
	}