<?php


	namespace MehrIt\HetznerDnsApi\Models;

	use DateTime;
	use DateTimeInterface;

	class ResponseRecord extends Record
	{
		/**
		 * @inheritDoc
		 */
		public static function fromArray(array $data) {

			$model = parent::fromArray($data);

			$model->created  = ($created = ($data['created'] ?? null)) ? static::dateFromString($created) : null;
			$model->id       = $data['id'] ?? null;
			$model->modified = ($modified = ($data['modified'] ?? null)) ? static::dateFromString($modified) : null;

			return $model;
		}


		/**
		 * @var DateTimeInterface
		 */
		protected $created;

		/**
		 * @var string
		 */
		protected $id;

		/**
		 * @var DateTimeInterface
		 */
		protected $modified;


		/**
		 * Sets the created date
		 * @param DateTimeInterface $created The created date
		 * @return $this
		 */
		public function created(DateTimeInterface $created): Record {

			$this->created = $created;

			return $this;
		}

		/**
		 * Sets the id
		 * @param string $id The id
		 * @return $this
		 */
		public function id(string $id): Record {

			$this->id = $id;

			return $this;
		}

		/**
		 * Sets the modified date
		 * @param DateTimeInterface $modified The value
		 * @return $this
		 */
		public function modified(DateTimeInterface $modified): Record {

			$this->modified = $modified;

			return $this;
		}

		/**
		 * Gets the created date
		 * @return DateTimeInterface|DateTime|null The created date
		 */
		public function getCreated(): ?DateTimeInterface {
			return $this->created;
		}

		/**
		 * Gets the record id
		 * @return string|null The record id
		 */
		public function getId(): ?string {
			return $this->id;
		}

		/**
		 * Gets the modified date
		 * @return DateTimeInterface|DateTime|null The modified date
		 */
		public function getModified(): ?DateTimeInterface {
			return $this->modified;
		}


		/**
		 * @inheritDoc
		 */
		public function toArray(): array {

			return array_merge(
				parent::toArray(),
				array_filter(
					[
						'id'       => $this->id,
						'created'  => $this->created ? static::dateToString($this->created) : null,
						'modified' => $this->modified ? static::dateToString($this->modified) : null,
					],
					function ($v) {
						return $v !== null;
					}
				)
			);
		}

	}