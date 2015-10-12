<?php

namespace App;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use \Mockery;

use App\Libraries\SearchTrait;

class SearchTraitDummyClass
{
    use SearchTrait;
}

class SearchTraitTest extends \TestCase
{

	protected $mock;

	public function setUp()
	{
		$this->mock = Mockery::mock('query');
	}

	public function tearDown()
	{
		Mockery::close();
	}

	public function testCheckIfPaginationExistsEnvPagination()
	{
		$search = new SearchTraitDummyClass;

        $this->mock->shouldReceive('paginate')
			->once()
			->with(identicalTo(env('PAGINATION_NUMBER')))
			->andReturn(true);

		$query = $this->mock;

		$pagination = $search->checkIfPaginationExists($query);

		$this->assertTrue($pagination);
	}

	public function testCheckIfPaginationExistsCustomPagination()
	{
		$search = new SearchTraitDummyClass;

		$number = rand(1,40);

		$search->setPagination($number);

        $this->mock->shouldReceive('paginate')
			->once()
			->with($number)
			->andReturn(true);

		$query = $this->mock;

		$pagination = $search->checkIfPaginationExists($query);

		$this->assertTrue($pagination);
	}

	public function testcheckIfRelationsExists()
	{
		$search = new SearchTraitDummyClass;

        $this->mock->shouldReceive('with')
			->between(0, 1)
			->with(Mockery::subset(array('join')))
			->andReturn(true);

		$query = $this->mock;

		$result = $search->checkIfRelationsExists($query, ['join']);

		$this->assertTrue($result);
	}

	public function testcheckIfRelationsExistsWithNoJoin()
	{
		$search = new SearchTraitDummyClass;

        $this->mock->shouldReceive('with')
			->between(0, 1)
			->with(anyThing())
			->andReturn(true);

		$query = $this->mock;

		$result = $search->checkIfRelationsExists($query);

		$this->assertFalse($result);
	}

	public function testcheckIfSearchExists()
	{
		$search = new SearchTraitDummyClass;

        $this->mock->shouldReceive('where')
			->between(0, 1)
			->with('/^column$/', '/^LIKE$/', '/^%keyword%$/')
			->andReturn(true);

		$query = $this->mock;

		$result = $search->checkIfSearchExists('keyword', 'column', $query);

		$this->assertTrue($result);
	}

	public function testcheckIfSearchExistsWithNoKeyword()
	{
		$search = new SearchTraitDummyClass;

        $this->mock->shouldReceive('where')
			->between(0, 1)
			->with(anyThing())
			->andReturn(true);

		$query = $this->mock;

		$result = $search->checkIfSearchExists('', 'column', $query);

		$this->assertFalse($result);
	}

	public function testcheckIfSearchExistsWithNoColumn()
	{
		$search = new SearchTraitDummyClass;

        $this->mock->shouldReceive('where')
			->between(0, 1)
			->with(anyThing())
			->andReturn(true);

		$query = $this->mock;

		$result = $search->checkIfSearchExists('keyword', NULL, $query);

		$this->assertFalse($result);
	}

	public function testcheckIfSearchExistsWithNoArgs()
	{
		$search = new SearchTraitDummyClass;

        $this->mock->shouldReceive('where')
			->between(0, 1)
			->with(anyThing())
			->andReturn(true);

		$query = $this->mock;

		$result = $search->checkIfSearchExists('', NULL, $query);

		$this->assertFalse($result);
	}

}
