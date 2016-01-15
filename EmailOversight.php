<?php

namespace Bcismariu\EmailOversight;

class EmailOversight
{
	private $parameters = [
		'apitoken'	=> null,
		'listid'	=> null,
		'email'		=> null,
	];

	protected $url = 'https://api.emailoversight.com/api/';

	public function __construct($parameters = [])
	{
		if (gettype($parameters) == 'string') {
			$apitoken = $parameters;
			$parameters = [];
			$parameters['apitoken'] = $apitoken;
		}
		foreach ($parameters as $key => $value) {
			$this->setParameter($key, $value);
		}
	}

	public function emailValidation($email, $listid = null)
	{
		$this->setParameter('email', $email);
		if ($listid) {
			// if this is not set we will use the global value
			$this->setParameter('listid', $listid);
		}
		return $this->post('emailvalidation', ['email', 'listid']);
	}


	protected function get($method, $parameters = [])
	{
		$parameters['apitoken'] = $this->parameters['apitoken'];
		$query = $this->buildQuery($method, $parameters);
		$result = file_get_contents($query);
		return $this->parseResult($result);
	}

	protected function post($method, $parameters = [])
	{
		$options = [
			'http'	=> [
				'header'	=> "Content-type: application/json; charset=utf-8\r\n"
							 . "ApiToken: " . $this->parameters['apitoken'] . "\r\n",
				'method'	=> "POST",
				'content'	=> json_encode($this->getApiParameters($parameters)),
			],
		];
		$context = stream_context_create($options);
		$result = file_get_contents($this->url . $method, false, $context);
		return $this->parseResult($result);
	}


	protected function buildQuery($method, $parameters)
	{
		return $this->url . $method
			. '?' . http_build_query($this->getApiParameters($parameters));
	}

	protected function setParameter($key, $value = null)
	{
		$key = strtolower(trim($key));
		if (!array_key_exists($key, $this->parameters)) {
			return;
		}
		$this->parameters[$key] = $value;
	}

	protected function getApiParameters($parameters)
	{
		$api = [];
		foreach ($parameters as $key) {
			$api[$key] = $this->parameters[$key];
		}
		return $api;
	}

	public function parseResult($result)
	{
		return json_decode($result);
	}
}
