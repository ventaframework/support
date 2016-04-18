<?php

/**
 * Class DotAccessTest
 */
class DotAccessTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function canGetItemsWithFunction()
    {
        $this->assertEquals('root', array_dot_get($this->_getData(), 'database.mysql.user'));
        $this->assertEquals(123, array_dot_get($this->_getData(), 'tree.leaf'));
        $this->assertNull(array_dot_get($this->_getData(), 'non.existing.key'));
        $this->assertEquals('not-found', array_dot_get($this->_getData(), 'non.existing.key', 'not-found'));
    }

    /**
     * @test
     */
    public function canSetDataWithFunctions()
    {
        $data = [];

        array_dot_set($data, 'test', 123);
        array_dot_set($data, 'database.user', 'root');
        array_dot_set($data, 'database.password', 'root');

        $this->assertEquals(123, array_dot_get($data, 'test'));
        $this->assertEquals('root', array_dot_get($data, 'database.user'));
        $this->assertEquals('root', array_dot_get($data, 'database.password'));
    }

    /**
     * @test
     */
    public function canSearchItems()
    {
        $data = $this->_getData();

        $this->assertTrue(array_dot_has($data, 'database'));
        $this->assertTrue(array_dot_has($data, 'database.mysql'));
        $this->assertTrue(array_dot_has($data, 'database.mysql.user'));
        $this->assertFalse(array_dot_has($data, 'database.mysql.test'));
    }

    /**
     * @test
     */
    public function canRemoveItems()
    {
        $data = $this->_getData();
        array_dot_remove($data, 'database');
        array_dot_remove($data, 'tree.leaf');
        array_dot_remove($data, 'tree.subtree.leaf');
        array_dot_remove($data, 'tree.subtree.subtree');

        $this->assertEquals(['tree' => ['subtree' => []]], $data);
    }

    /**
     * Returns array with data for testing
     *
     * @return array
     */
    protected function _getData()
    {
        return [
            'database' => [
                'mysql' => [
                    'user' => 'root',
                    'password' => 'root',
                    'db' => 'test'
                ],
                'sqlite' => [
                    'storage' => 'file.sql',
                    'user' => 'root'
                ]
            ],
            'tree' => [
                'leaf' => 123,
                'subtree' => [
                    'leaf' => 'abc'
                ]
            ]
        ];
    }
}