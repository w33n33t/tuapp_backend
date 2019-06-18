<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Http\Request;
	use PhpParser\Builder\Class_;
	
	class CoreController extends Controller
	{
		public function create($request, $module)
		{
		
		
		}
		
		public function show()
		{
		
		
		}
		
		public function update()
		{
		
		}
		
		public function store()
		{
		
		}
		
		public function get(Request $request, Model $model)
		{
			//TODO 1- processare richiesta
			//TODO 3- passareQueryAdattatore
			$model->processRequest();
			
			//TODO 4-ritornare i dati
		
		}
		
		protected $requestConfigArray = [
			'type'      => null,
			'by'        => null,
			'condition' => null
		];
}
