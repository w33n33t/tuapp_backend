<?php
	
	namespace App\Adapters;
	
	
	abstract class AdapterFactory
	{
		protected $adapter;
		
		public static function create($adapter, $arg)
		{
			$adapter = $adapter.'Adapter';
			return new $adapter($arg);
		}
		
		
		public function store($request)
		{
			$input = $request->all();
			$service = $this->serviceRepository->create($input);
			return $this->adapter->store($request);
		}
		
		public function update($request)
		{
			return $this->adapter->update($request);
		}
		
		public function delete($request)
		{
			return $this->adapter->delete($request);
		}
		
		public function validate($arg)
		{
			return $this->adapter->validate($arg);
		}
		
		
		abstract public function AfterStore($arg);
		
		abstract public function BeforeStore($arg);
		
		abstract public function AfterUpdate($arg);
		
		abstract public function BeforeUpdate($arg);
		
		abstract public function AfterDelete($arg);
		
		abstract public function BeforeDelete($arg);
		
		abstract public function AfterValidate($arg);
		
		abstract public function BeforeValidate($arg);
		
		
		public function processRequest($request)
		{
			
			return $this->model->process($request);
			
		}
		
	}
	
	
	?>