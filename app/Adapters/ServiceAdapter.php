<?php
	
	
	namespace App\Adapters;
	
	
	use App\Models\Service\Service;
	
	class ServiceAdapter extends AdapterFactory
	{
		private $service;
		public function __construct()
		{
		}
		
		
		public function getAdapter($adapter, $arg)
		{
			return $this;
		}
		
		
	}