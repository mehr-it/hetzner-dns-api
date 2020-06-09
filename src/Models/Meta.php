<?php


	namespace MehrIt\HetznerDnsApi\Models;


	class Meta extends AbstractEntity
	{
		/**
		 * @inheritDoc
		 */
		public static function fromArray(array $data) {
			$model = new static();

			$model->pagination = Pagination::fromArray((array)($data['pagination'] ?? []));

			return $model;
		}


		/**
		 * @var Pagination
		 */
		protected $pagination;


		/**
		 * Sets the pagination data
		 * @param Pagination $pagination The pagination
		 * @return $this
		 */
		public function pagination(Pagination $pagination): Meta {
			$this->pagination = $pagination;

			return $this;
		}

		/**
		 * Gets the pagination data
		 * @return Pagination|null The pagination data
		 */
		public function getPagination(): ?Pagination {

			return $this->pagination;
		}



		/**
		 * @inheritDoc
		 */
		public function toArray(): array {
			$ret = [];

			if ($this->pagination)
				$ret['pagination'] = $this->pagination->toArray();

			return $ret;
		}


	}