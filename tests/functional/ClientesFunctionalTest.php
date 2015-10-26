<?php

class ClientesFunctionalTest extends PHPUnit_Extensions_Selenium2TestCase
{

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

	public function getCredentials()
	{
		return [
			'email' => 'user@dataprensa.com',
			'password' => 'dataprensa.com'
		];
	}

	public function doLogin($credentials)
	{
		$this->byName('email')->value($credentials['email']);
    	$this->byName('password')->value($credentials['password']);
        $this->byName('login')->submit();
	}

	public function test_see_index()
    {
    	$this->url('/clientes');

    	$credentials = $this->getCredentials();
    	
    	$this->doLogin($credentials);

    	$content = $this->byTag('body')->text();
    	
    	$this->assertContains('Lista de Clientes', $content);
    	
    }

    public function test_see_crear()
    {
    	$this->url('/clientes');

    	$credentials = $this->getCredentials();
    	
    	$this->doLogin($credentials);

    	$this->byLinkText('Agregar un Cliente')->click();

    	$content = $this->byClassName('panel-title')->text();
    	
    	$this->assertContains('Agregar un Cliente', $content);
    	
    }

    public function test_crear()
    {
    	$this->url('/clientes/create');

    	$credentials = $this->getCredentials();
    	
    	$this->doLogin($credentials);

    	$this->byName('clt_nombre')->value('Prueba');
    	$this->byName('clt_descripcion')->value('Descripcion');
    	$this->byName('clt_dominio')->value('http://dominio.com');
        $this->byCssSelector('.btn.btn-info.btn-block')->submit();
    }

    public function test_editar()
    {
    	$this->url('/clientes');

    	$credentials = $this->getCredentials();
    	
    	$this->doLogin($credentials);

    	$this->byName('keyword')->value('dominio.com');
    	$this->byName('column')->value('Dominio');
        $this->byCssSelector('.btn.btn-default')->submit();

        $this->byLinkText('Detalles')->click();

    	$this->byCssSelector('.btn.btn-primary')->submit();

    	$content = $this->byClassName('panel-title')->text();
    	
    	$this->assertContains('Editar un Cliente', $content);

    	$this->byName('clt_nombre')->value('Prueba editado');

    	$this->byCssSelector('.btn.btn-info.btn-block')->submit();

    	$content = $this->byClassName('text-center')->text();

        $this->assertContains('Lista de Clientes', $content);

    }

    public function test_buscar_borrar()
    {
    	$this->url('/clientes');

    	$credentials = $this->getCredentials();
    	
    	$this->doLogin($credentials);

    	$this->byName('keyword')->value('dominio.com');
    	$this->byName('column')->value('Dominio');
        $this->byCssSelector('.btn.btn-default')->submit();

        $content = $this->byClassName('alert-info')->text();

        $this->assertContains('Resultados de la búsqueda', $content);

        $this->byLinkText('Detalles')->click();

        $content = $this->byClassName('panel-title')->text();
    	
    	$this->assertContains('Información del Cliente', $content);

    	$this->byCssSelector('.btn.btn-success.btn-sm')->submit();
    }

}
