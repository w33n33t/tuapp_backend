<?php

namespace App\Http\Controllers\Service;

use App\DataTables\Service\ServiceDataTable;
use App\Http\Requests\Service;
use App\Http\Requests\Service\CreateServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Repositories\Service\ServiceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ServiceController extends AppBaseController
{
    /** @var  ServiceRepository */
    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepo)
    {
        $this->serviceRepository = $serviceRepo;
    }

    /**
     * Display a listing of the Service.
     *
     * @param ServiceDataTable $serviceDataTable
     * @return Response
     */
    public function index(ServiceDataTable $serviceDataTable)
    {
        return $serviceDataTable->render('service.services.index');
    }

    /**
     * Show the form for creating a new Service.
     *
     * @return Response
     */
    public function create()
    {
        return view('service.services.create');
    }

    /**
     * Store a newly created Service in storage.
     *
     * @param CreateServiceRequest $request
     *
     * @return Response
     */
    public function store(CreateServiceRequest $request)
    {
        $input = $request->all();

        $service = $this->serviceRepository->create($input);

        Flash::success('Service saved successfully.');

        return redirect(route('service.services.index'));
    }

    /**
     * Display the specified Service.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $service = $this->serviceRepository->find($id);

        if (empty($service)) {
            Flash::error('Service not found');

            return redirect(route('service.services.index'));
        }

        return view('service.services.show')->with('service', $service);
    }

    /**
     * Show the form for editing the specified Service.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $service = $this->serviceRepository->find($id);

        if (empty($service)) {
            Flash::error('Service not found');

            return redirect(route('service.services.index'));
        }

        return view('service.services.edit')->with('service', $service);
    }

    /**
     * Update the specified Service in storage.
     *
     * @param  int              $id
     * @param UpdateServiceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateServiceRequest $request)
    {
        $service = $this->serviceRepository->find($id);

        if (empty($service)) {
            Flash::error('Service not found');

            return redirect(route('service.services.index'));
        }

        $service = $this->serviceRepository->update($request->all(), $id);

        Flash::success('Service updated successfully.');

        return redirect(route('service.services.index'));
    }

    /**
     * Remove the specified Service from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $service = $this->serviceRepository->find($id);

        if (empty($service)) {
            Flash::error('Service not found');

            return redirect(route('service.services.index'));
        }

        $this->serviceRepository->delete($id);

        Flash::success('Service deleted successfully.');

        return redirect(route('service.services.index'));
    }
}
