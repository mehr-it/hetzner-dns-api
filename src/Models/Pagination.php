<?php


	namespace MehrIt\HetznerDnsApi\Models;


	use InvalidArgumentException;

	class Pagination extends AbstractEntity
	{
		/**
		 * @inheritDoc
		 */
		public static function fromArray(array $data) {

			$model = new static();

			$model->page         = $data['page'] ?? null;
			$model->perPage      = $data['per_page'] ?? null;
			$model->lastPage     = $data['last_page'] ?? null;
			$model->totalEntries = $data['total_entries'] ?? null;

			return $model;
		}


		/**
		 * @var int
		 */
		protected $page;

		/**
		 * @var int
		 */
		protected $perPage;

		/**
		 * @var int
		 */
		protected $lastPage;

		/**
		 * @var int
		 */
		protected $totalEntries;


		/**
		 * Sets the page number
		 * @param int $page The page number
		 * @return $this
		 */
		public function page(int $page): Pagination {

			if ($page < 1)
				throw new InvalidArgumentException('Page must be greater than 0');

			$this->page = $page;

			return $this;
		}

		/**
		 * Sets the number of records per page
		 * @param int $perPage The number of records per page
		 * @return $this
		 */
		public function perPage(int $perPage): Pagination {

			if ($perPage < 1)
				throw new InvalidArgumentException('PerPage must be greater than 0');

			$this->perPage = $perPage;

			return $this;
		}

		/**
		 * Sets the last page number
		 * @param int $lastPage The last page number
		 * @return $this
		 */
		public function lastPage(int $lastPage): Pagination {

			if ($lastPage < 1)
				throw new InvalidArgumentException('LastPage must be greater than 0');

			$this->lastPage = $lastPage;

			return $this;
		}


		/**
		 * Sets the total count
		 * @param int $totalEntries The total number of entries
		 * @return $this
		 */
		public function totalEntries(int $totalEntries): Pagination {

			if ($totalEntries < 0)
				throw new InvalidArgumentException('totalEntries must be greater or equal than 0');

			$this->totalEntries = $totalEntries;

			return $this;
		}

		/**
		 * Gets the page number
		 * @return int The page number
		 */
		public function getPage(): ?int {
			return $this->page;
		}

		/**
		 * Gets the number of records per page
		 * @return int The number of records per page
		 */
		public function getPerPage(): ?int {
			return $this->perPage;
		}

		/**
		 * Gets the last page number
		 * @return int The last page number
		 */
		public function getLastPage(): ?int {
			return $this->lastPage;
		}

		/**
		 * Gets the number of total entries
		 * @return int The number of total entries
		 */
		public function getTotalEntries(): ?int {
			return $this->totalEntries;
		}


		/**
		 * @inheritDoc
		 */
		public function toArray(): array {

			return array_filter(
				[
					'page'          => $this->page,
					'per_page'      => $this->perPage,
					'last_page'     => $this->lastPage,
					'total_entries' => $this->totalEntries,
				],
				function ($v) {
					return $v !== null;
				}
			);
		}

	}