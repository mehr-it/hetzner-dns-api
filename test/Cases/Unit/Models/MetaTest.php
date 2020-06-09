<?php


	namespace MehrItHetznerDnsApiTest\Cases\Unit\Models;


	use MehrIt\HetznerDnsApi\Models\Meta;
	use MehrIt\HetznerDnsApi\Models\Pagination;
	use MehrItHetznerDnsApiTest\Cases\TestCase;
	use PHPUnit\Framework\MockObject\MockObject;

	class MetaTest extends TestCase
	{

		public function testConstructGetters() {

			$meta = new Meta();

			$this->assertSame(null, $meta->getPagination());

		}

		public function testSettersAndGetters() {

			$meta = new Meta();

			/** @var Pagination|MockObject $pagination */
			$pagination = $this->getMockBuilder(Pagination::class)->getMock();

			$this->assertSame($meta, $meta->pagination($pagination));

			$this->assertSame($pagination, $meta->getPagination());
		}

		public function testToArray() {
			$meta = new Meta();

			/** @var Pagination|MockObject $paginationMock */
			$paginationMock = $this->getMockBuilder(Pagination::class)->getMock();
			$paginationMock
				->method('toArray')
				->willReturn([
					'x' => 'array:pagination'
				]);

			$meta->pagination($paginationMock);

			$this->assertArrayHasKeysAndValuesAssoc([
				'pagination' => [
					'x' => 'array:pagination'
				],
			], $meta->toArray());
		}

		public function testJsonSerialize() {
			$meta = new Meta();

			/** @var Pagination|MockObject $paginationMock */
			$paginationMock = $this->getMockBuilder(Pagination::class)->getMock();
			$paginationMock
				->method('toArray')
				->willReturn([
					'x' => 'array:pagination'
				]);

			$meta->pagination($paginationMock);

			$this->assertArrayHasKeysAndValuesAssoc([
				'pagination' => [
					'x' => 'array:pagination'
				],
			], $meta->jsonSerialize());
		}

		public function testFromArray() {

			$meta = Meta::fromArray([
				'pagination' => [
					'page' => 1
				]
			]);

			$this->assertInstanceOf(Pagination::class, $meta->getPagination());
			$this->assertSame(1, $meta->getPagination()->getPage());

		}

	}