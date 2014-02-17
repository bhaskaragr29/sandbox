<?php
/**
 * @author    Bhaskar Agarwal <bhaskar.agarwal@paddypower.com>
 * @created   Feb 17, 2014 - 1:04:12 PM
 * @encoding  UTF-8
 */

use Guzzle\Http\Client;

class LiveCalendarWebTest extends \PHPUnit_Framework_TestCase {

  protected $client;

  public function setUp() {
    $this->client = new Client('http://paddyrest.localhost/bir/1.0');
    $this->client->setSslVerification(FALSE);
  }

  /**
   * @test
   */
  public function testSave() {
    $test_array = array(
      'created_at'=>time(),
      'updated_at'=>time(),
      'type'=>'test_type',
      'active'=>1,
      'data'=>'abcs'
    );
    $request = $this->client->put('livecalendar/0',array('Content-Type' => 'application/json; charset=UTF8'), json_encode($test_array), array('timeout' => 120));
    $response = $request->send();
    if($response->isSuccessful()){
      $data = $response->json();
      $this->assertArrayHasKey('live_calendar', $data);
      $result = $data['live_calendar'][0];
      unset($result['id']);
      $this->assertEquals($test_array, $result);
      return $data;
    }else{
      $this->assertFalse(TRUE);
    }
  }

  /**
   * @test
   */
  public function testSaveFail(){
    $test_array = array(
        'created_at'=>time(),
        'updated_at'=>time(),
        'type'=>'test_type',
        'active'=>1
    );
    try{
      $request = $this->client->put('livecalendar/0',array('Content-Type' => 'application/json; charset=UTF8'), json_encode($test_array), array('timeout' => 120));
      $response = $request->send();
    }catch (Guzzle\Http\Exception\BadResponseException $e){
      $this->assertEquals(500, $e->getResponse()->getStatusCode());
    }
  }

  /**
   * @test
   * @depends testSave
   */
  public function testUpdate(array $data){
    $test_data = $data['live_calendar'][0];
    $test_data['data'] = 'new_data'.time();
    $request = $this->client->put('livecalendar/'.$test_data['id'],array('Content-Type' => 'application/json; charset=UTF8'), json_encode($test_data), array('timeout' => 120));
    $response = $request->send();
    if($response->isSuccessful()){
      $data = $response->json();
      $this->assertArrayHasKey('live_calendar', $data);
      $result = $data['live_calendar'][0];
      $this->assertEquals($test_data, $result);
    }else{
      $this->assertFalse(TRUE);
    } 
  } 

  /**
   * @test
   * @depends testSave
   */
  public function testUpdateFail(array $data){
    $test_data = $data['live_calendar'][0];
    try{
      $request = $this->client->put('livecalendar/'.$test_data['id'],array('Content-Type' => 'application/json; charset=UTF8'), json_encode($test_data), array('timeout' => 120));
      $response = $request->send();
    }catch (Guzzle\Http\Exception\BadResponseException $e){
      $this->assertEquals(500, $e->getResponse()->getStatusCode());
    }
  }

  /**
   * @test
   * @depends testSave
   */
  public function getbyIds(array $data){
    //@Add one more data
    $test_data = $data['live_calendar'][0];
    $request = $this->client->get('livecalendar/'.$test_data['id'],array('Content-Type' => 'application/json; charset=UTF8'));
    $response = $request->send();
    if($response->isSuccessful()){
      $data = $response->json();
      $this->assertArrayHasKey('live_calendar', $data);
      $result = $data['live_calendar'][0];
      $this->assertEquals($test_data, $result);
    }else{
      $this->assertFalse(TRUE);
    }
  } 

  /**
   * @test
   * @depends testSave
   */
  /* public function getbyTypeIds(){
  
  } */

  /**
   * @test
   */
  public function test404(){
    try{
      $request = $this->client->get('live/',array('Content-Type' => 'application/json; charset=UTF8'));
      $response = $request->send();
    }catch (Guzzle\Http\Exception\BadResponseException $e){
      $this->assertEquals(404, $e->getResponse()->getStatusCode());
    } 
  }

  //@TODO::later add auth testing
}
