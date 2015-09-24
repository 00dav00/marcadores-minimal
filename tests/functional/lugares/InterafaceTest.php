<?php

use Laracasts\Integrated\Services\Laravel\Application as Laravel;
use \SeleniumLoginTrait as Login;

class InterfaceTest extends \PHPUnit_Extensions_Selenium2TestCase
{

	use Laravel,Login;

	public function setUp()
    {
        $this->setHost('localhost');
        $this->setPort(4444);
        $this->setBrowserUrl('http://resultados.app');
        $this->setBrowser('firefox');
    }

    public function tearDown()
	{
	    $this->stop();
	}

	public function testFormSubmissionWithUsername()
    {
        $this->url('/lugares/create');

        $this->byName('email')->value('juanelojga@gmail.com');
        $this->byName('password')->value('jga2588332');
        $this->byName('login')->submit();

            $this->select($this->byId('parent_lug_id'))
            	->click()
            	->getKeyboard()
            	->sendKeys('gua');


        sleep(5);
    }

}