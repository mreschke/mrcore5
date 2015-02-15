<?php namespace Mrcore\Mrcore;

class Config implements ConfigInterface
{

	public function host()
	{
		return \Config::get('mrcore.host');	
	}

	public function base()
	{
		return base_path();
	}

	public function baseUrl()
	{
		return \Config::get('mrcore.base_url');
	}

	public function files()
	{
		return \Config::get('mrcore.files');
	}

	public function filesBaseUrl()
	{
		return \Config::get('mrcore.file_base_url');
	}

}
