<?php


	namespace MehrItHetznerDnsApiTest\Cases\Unit\Models;


	use MehrIt\HetznerDnsApi\Models\Pagination;
	use MehrItHetznerDnsApiTest\Cases\TestCase;

	class PaginationTest extends TestCase
	{
		public function testConstructGetters() {

			$pagination = new Pagination();

			$this->assertSame(null, $pagination->getPage());
			$this->assertSame(null, $pagination->getLastPage());
			$this->assertSame(null, $pagination->getPerPage());
			$this->assertSame(null, $pagination->getTotalEntries());

		}

		public function testSettersAndGetters() {

			$pagination = new Pagination();

			$this->assertSame($pagination, $pagination->page(1));
			$this->assertSame($pagination, $pagination->lastPage(5));
			$this->assertSame($pagination, $pagination->perPage(2));
			$this->assertSame($pagination, $pagination->totalEntries(9));

			$this->assertSame(1, $pagination->getPage());
			$this->assertSame(5, $pagination->getLastPage());
			$this->assertSame(2, $pagination->getPerPage());
			$this->assertSame(9, $pagination->getTotalEntries());

		}

		public function testToArray() {

			$pagination = new Pagination();

			$pagination->page(1);
			$pagination->lastPage(5);
			$pagination->perPage(2);
			$pagination->totalEntries(9);

			$this->assertArrayHasKeysAndValuesAssoc([
				'page' => 1,
				'per_page' => 2,
				'last_page' => 5,
				'total_entries' => 9,
			], $pagination->toArray());
		}

		public function testJsonSerialize() {

			$pagination = new Pagination();

			$pagination->page(1);
			$pagination->lastPage(5);
			$pagination->perPage(2);
			$pagination->totalEntries(9);

			$this->assertArrayHasKeysAndValuesAssoc([
				'page' => 1,
				'per_page' => 2,
				'last_page' => 5,
				'total_entries' => 9,
			], $pagination->jsonSerialize());
		}

		public function testFromArray() {

			$pagination = Pagination::fromArray([
				'page'          => 1,
				'per_page'      => 2,
				'last_page'     => 5,
				'total_entries' => 9,
			]);

			$this->assertSame(1, $pagination->getPage());
			$this->assertSame(5, $pagination->getLastPage());
			$this->assertSame(2, $pagination->getPerPage());
			$this->assertSame(9, $pagination->getTotalEntries());
		}
	}