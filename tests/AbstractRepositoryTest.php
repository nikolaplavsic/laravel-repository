<?php

class AbstractRepositoryTest extends PHPUnit_Framework_TestCase
{

	protected function setUp()
	{
		// create mock for DB
		$this->db = $this->mockConnection();

		// create stub for Abstract Repository
		$this->stub = $this	->getMockBuilder('NPlavsic\LRepository\AbstractRepository')
							->setConstructorArgs(array($this->db))
							->getMockForAbstractClass();

		
	}

	/**
	 * @expectedException BadMethodCallException
	 * @expectedExceptionMessage Unkonown method abcdefg.
	 */
	public function testCallToUnknownMethod()
	{
		$this->stub->abcdefg();
	}

	/**
	 * @test
	 */
	public function testTransactionMethods()
	{
		// defaults to null
		$transactionMethods = $this->stub->getTransactionMethods();
		$this->assertNull($transactionMethods);
	}

	/**
	 * @test
	 */
	public function testCallToCreateMethod()
	{
		$this->db 	->expects($this->once())
					->method('beginTransaction')
					->willReturn(true);

		$this->db 	->expects($this->once())
					->method('commit')
					->willReturn(true);

		$this->stub ->expects($this->once())
			 		->method('_create')
			 		->willReturn(true);

		$this->assertTrue($this->stub->create(false));
	}

	/**
	 * @test
	 */
	public function testCallToUpdateMethod()
	{
		$this->db 	->expects($this->once())
					->method('beginTransaction')
					->willReturn(true);

		$this->db 	->expects($this->once())
					->method('commit')
					->willReturn(true);

		$this->stub ->expects($this->once())
			 		->method('_update')
			 		->willReturn(true);

		$this->assertTrue($this->stub->update(1, false));
	}

	/**
	 * @test
	 */
	public function testCallToDeleteMethod()
	{
		$this->db 	->expects($this->once())
					->method('beginTransaction')
					->willReturn(true);

		$this->db 	->expects($this->once())
					->method('commit')
					->willReturn(true);

		$this->stub ->expects($this->once())
			 		->method('_delete')
			 		->willReturn(true);

		$this->assertTrue($this->stub->delete(false));
	}

	/**
	 * @test
	 */
	public function testCallToFetchMethod()
	{
		$this->db 	->expects($this->once())
					->method('beginTransaction')
					->willReturn(true);

		$this->db 	->expects($this->once())
					->method('commit')
					->willReturn(true);

		$this->stub ->expects($this->once())
			 		->method('_fetch')
			 		->willReturn(true);

		$this->assertTrue($this->stub->fetch(false));
	}

	/**
	 * @test
	 */
	public function testCallToFilterMethod()
	{
		$this->db 	->expects($this->once())
					->method('beginTransaction')
					->willReturn(true);

		$this->db 	->expects($this->once())
					->method('commit')
					->willReturn(true);

		$this->stub ->expects($this->once())
			 		->method('_filter')
			 		->willReturn(true);

		$this->assertTrue($this->stub->filter(false));
	}

	/**
	 * Get mock for Illuminate\Database\Connection
	 */
	public function mockConnection()
	{
		return $this->getMockBuilder('Illuminate\Database\Connection')
					->disableOriginalConstructor()
					->setMethods(array('beginTransaction', 'commit', 'rollback'))
					->getMock();
	}
}