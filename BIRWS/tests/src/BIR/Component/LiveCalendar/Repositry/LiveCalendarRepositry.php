<?php
/**
 * @author    Bhaskar Agarwal <bhaskar.agarwal@paddypower.com>
 * @created   Feb 17, 2014 - 1:04:12 PM
 * @encoding  UTF-8
 */

namespace BIR\Component\LiveCalendar\Repositry;
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Symfony\Component\HttpFoundation\Request;


class LiveRepositryTest extends \PHPUnit_Framework_TestCase{
  
  protected $app;
  
  
  public function setUp(){
    $this->app = new Application();
    $this->app->register(
        new DoctrineServiceProvider(),
        array(
            'db.options' => array(
                'driver' => 'pdo_sqlite',
                'memory' => true,
                'path'   => DATABASE_PATH . '/test.db',
            ),
        )
    );
    $schema = $this->app['db']->getSchemaManager();
    $this->createLiveCalendarTable($schema);
    $this->liveRepo = new LiveCalendarRepositry($this->app['db']);
  } 
  
  /**
   * Build out the table we need in the sqlite memory db.
   *
   * @param $schema
   */
  private function createLiveCalendarTable($schema)
  {
    if ($schema->tablesExist('live_calendar')) {
      $schema->dropTable('live_calendar');
    }
  
    $liveCalendar = new \Doctrine\DBAL\Schema\Table('live_calendar');
    $liveCalendar->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement' => true));
    $liveCalendar->setPrimaryKey(array('id'));
    $liveCalendar->addColumn('type', 'string');
    $liveCalendar->addColumn('data', 'text', array());
    $liveCalendar->addColumn('active', 'integer', array('unsigned' => true, 'default' => 1));
    $liveCalendar->addColumn('created_at', 'integer', array('unsigned' => true,));
    $liveCalendar->addColumn('updated_at', 'integer', array('unsigned' => true,));
    $schema->createTable($liveCalendar);
  }
  
  /**
   * @test
   */
  public function saveNew(){
      
  }
  
  /**
   * @test
   */
  public function update(){
    
  }
  
  /**
   * @test
   */
  public function saveFailNoData(){
    
  }
  
  /**
   * @test
   */
  public function saveFailNoType(){
  
  }
  
  /**
   * @test
   */
  public function updateFail(){
  
  }
  
  /**
   * @test
   * @depends saveNew
   */
  public function getAll(){
    
  }
  
  /**
   * @test
   * @depends saveNew
   */
  public function getByType(){
    
  }
  
  /**
   * @test
   * @depends saveNew
   */
  public function getByIds(){
    
  }
  
  
  
  
  
  
}