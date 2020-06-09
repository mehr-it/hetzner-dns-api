<?php


	namespace MehrIt\HetznerDnsApi\Models;


	use DateTime;
	use DateTimeInterface;
	use InvalidArgumentException;

	class ResponseZone extends Zone
	{
		const STATUS_FAILED = 'failed';
		const STATUS_PENDING = 'pending';
		const STATUS_VERIFIED = 'verified';

		/**
		 * @inheritDoc
		 */
		public static function fromArray(array $data) {

			$model = parent::fromArray($data);

			$model->created         = ($created = ($data['created'] ?? null)) ? static::dateFromString($created) : null;
			$model->id              = $data['id'] ?? null;
			$model->secondaryDns    = $data['is_secondary_dns'] ?? null;
			$model->legacyDnsHost   = $data['legacy_dns_host'] ?? null;
			$model->legacyNs        = (array)($data['legacy_ns'] ?? []);
			$model->modified        = ($modified = ($data['modified'] ?? null)) ? static::dateFromString($modified) : null;
			$model->ns              = (array)($data['ns'] ?? []);
			$model->owner           = $data['owner'] ?? null;
			$model->paused          = $data['paused'] ?? null;
			$model->permission      = $data['permission'] ?? null;
			$model->project         = $data['project'] ?? null;
			$model->recordsCount    = $data['records_count'] ?? null;
			$model->registrar       = $data['registrar'] ?? null;
			$model->status          = $data['status'] ?? null;
			$model->txtVerification = TxtVerification::fromArray((array)($data['txt_verification'] ?? []));
			$model->verified        = ($verified = ($data['verified'] ?? null)) ? static::dateFromString($verified) : null;

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
		 * @var string
		 */
		protected $legacyDnsHost;

		/**
		 * @var string[]
		 */
		protected $legacyNs = [];

		/**
		 * @var DateTimeInterface
		 */
		protected $modified;

		/**
		 * @var string[]
		 */
		protected $ns = [];

		/**
		 * @var string
		 */
		protected $owner;

		/**
		 * @var bool
		 */
		protected $paused;

		/**
		 * @var string
		 */
		protected $permission;

		/**
		 * @var string
		 */
		protected $project;

		/**
		 * @var int
		 */
		protected $recordsCount;

		/**
		 * @var string
		 */
		protected $registrar;

		/**
		 * @var bool
		 */
		protected $secondaryDns;

		/**
		 * @var string
		 */
		protected $status;

		/**
		 * @var TxtVerification
		 */
		protected $txtVerification;

		/**
		 * @var DateTimeInterface
		 */
		protected $verified;


		/**
		 * Sets the created date
		 * @param DateTimeInterface $created The created date
		 * @return $this
		 */
		public function created(DateTimeInterface $created): ResponseZone {

			$this->created = $created;

			return $this;
		}

		/**
		 * Sets the id
		 * @param string $id The id
		 * @return $this
		 */
		public function id(string $id): ResponseZone {

			$this->id = $id;

			return $this;
		}

		/**
		 * Sets the legacy DNS host
		 * @param string $legacyDnsHost The legacy DNS host
		 * @return $this
		 */
		public function legacyDnsHost(string $legacyDnsHost): ResponseZone {

			$this->legacyDnsHost = $legacyDnsHost;

			return $this;
		}

		/**
		 * Sets the legacy NS
		 * @param array $legacyNs The legacy NS
		 * @return $this
		 */
		public function legacyNs(array $legacyNs): ResponseZone {

			$this->legacyNs = array_values($legacyNs);

			return $this;
		}

		/**
		 * Sets the modified date
		 * @param DateTimeInterface $modified The value
		 * @return $this
		 */
		public function modified(DateTimeInterface $modified): ResponseZone {

			$this->modified = $modified;

			return $this;
		}

		/**
		 * Sets the NS
		 * @param array $ns The NS
		 * @return $this
		 */
		public function ns(array $ns): ResponseZone {

			$this->ns = array_values($ns);

			return $this;
		}

		/**
		 * Sets the owner
		 * @param string $owner The owner
		 * @return $this
		 */
		public function owner(string $owner): ResponseZone {

			$this->owner = $owner;

			return $this;
		}

		/**
		 * Sets the paused flag
		 * @param bool $paused The paused flag
		 * @return $this
		 */
		public function paused(bool $paused): ResponseZone {

			$this->paused = $paused;

			return $this;
		}

		/**
		 * Sets the permission
		 * @param string $permission The permission
		 * @return $this
		 */
		public function permission(string $permission): ResponseZone {

			$this->permission = $permission;

			return $this;
		}

		/**
		 * Sets the project
		 * @param string $project The project
		 * @return $this
		 */
		public function project(string $project): ResponseZone {

			$this->project = $project;

			return $this;
		}

		/**
		 * Sets the records count
		 * @param int $recordsCount The records count
		 * @return $this
		 */
		public function recordsCount(int $recordsCount): ResponseZone {

			if ($recordsCount < 0)
				throw new InvalidArgumentException('Records count must not be negative');

			$this->recordsCount = $recordsCount;

			return $this;
		}

		/**
		 * Sets the registrar
		 * @param string $registrar The registrar
		 * @return $this
		 */
		public function registrar(string $registrar): ResponseZone {

			$this->registrar = $registrar;

			return $this;
		}

		/**
		 * Sets the secondary DNS flag
		 * @param bool $secondaryDns The secondary DNS flag
		 * @return $this
		 */
		public function secondaryDns(bool $secondaryDns): ResponseZone {

			$this->secondaryDns = $secondaryDns;

			return $this;
		}

		/**
		 * Sets the status
		 * @param string $status The status
		 * @return $this
		 */
		public function status(string $status): ResponseZone {

			$this->status = $status;

			return $this;
		}

		/**
		 * Sets the TXT verification
		 * @param TxtVerification $txtVerification The TXT verification
		 * @return $this
		 */
		public function txtVerification(TxtVerification $txtVerification): ResponseZone {

			$this->txtVerification = $txtVerification;

			return $this;
		}

		/**
		 * Sets the verified date
		 * @param DateTimeInterface $verified The verified date
		 * @return $this
		 */
		public function verified(DateTimeInterface $verified): ResponseZone {

			$this->verified = $verified;

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
		 * Gets the legacy DNS host
		 * @return string The legacy DNS host
		 */
		public function getLegacyDnsHost(): ?string {
			return $this->legacyDnsHost;
		}

		/**
		 * Gets the legacy NS
		 * @return string[] The legacy NS
		 */
		public function getLegacyNs(): array {
			return $this->legacyNs;
		}

		/**
		 * Gets the NS
		 * @return string[] The NS
		 */
		public function getNs(): array {
			return $this->ns;
		}

		/**
		 * Gets the owner
		 * @return string The owner
		 */
		public function getOwner(): ?string {
			return $this->owner;
		}

		/**
		 * Gets the paused flag
		 * @return bool The paused flag
		 */
		public function isPaused(): ?bool {
			return $this->paused;
		}

		/**
		 * Gets the permission
		 * @return string The permission
		 */
		public function getPermission(): ?string {
			return $this->permission;
		}

		/**
		 * Gets the project
		 * @return string The project
		 */
		public function getProject(): ?string {
			return $this->project;
		}

		/**
		 * Gets the records count
		 * @return int The records count
		 */
		public function getRecordsCount(): ?int {
			return $this->recordsCount;
		}

		/**
		 * Gets the registrar
		 * @return string The registrar
		 */
		public function getRegistrar(): ?string {
			return $this->registrar;
		}

		/**
		 * Gets the secondary DNS flag
		 * @return bool The secondary DNS flag
		 */
		public function isSecondaryDns(): ?bool {
			return $this->secondaryDns;
		}

		/**
		 * Gets the status
		 * @return string The status
		 */
		public function getStatus(): ?string {
			return $this->status;
		}

		/**
		 * Gets the TXT verification
		 * @return TxtVerification The TXT verification
		 */
		public function getTxtVerification(): ?TxtVerification {
			return $this->txtVerification;
		}

		/**
		 * Gets the verified date
		 * @return DateTimeInterface The verified date
		 */
		public function getVerified(): ?DateTimeInterface {
			return $this->verified;
		}


		/**
		 * @inheritDoc
		 */
		public function toArray(): array {

			return array_merge(
				parent::toArray(),
				array_filter(
					[
						'created'          => $this->created ? static::dateToString($this->created) : null,
						'id'               => $this->id,
						'is_secondary_dns' => $this->secondaryDns !== null ? (bool)$this->secondaryDns : null,
						'legacy_dns_host'  => $this->legacyDnsHost,
						'legacy_ns'        => $this->legacyNs,
						'modified'         => $this->modified ? static::dateToString($this->modified) : null,
						'ns'               => $this->ns,
						'owner'            => $this->owner,
						'paused'           => $this->paused !== null ? (bool)$this->paused : null,
						'permission'       => $this->permission,
						'project'          => $this->project,
						'records_count'    => $this->recordsCount,
						'registrar'        => $this->registrar,
						'status'           => $this->status,
						'txt_verification' => $this->txtVerification ? $this->txtVerification->toArray() : null,
						'verified'         => $this->verified ? static::dateToString($this->verified) : null,
					],
					function ($v) {

						if (is_array($v))
							return array_filter($v, function ($v) {
									return $v !== null;
								}) !== [];
						else
							return $v !== null;
					}
				)
			);
		}


	}