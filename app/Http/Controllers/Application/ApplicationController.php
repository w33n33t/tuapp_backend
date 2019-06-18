<?php

namespace App\Http\Controllers\Application;

use App\DataTables\Application\ApplicationDataTable;
use App\Http\Requests\Application;
use App\Http\Requests\Application\CreateApplicationRequest;
use App\Http\Requests\Application\UpdateApplicationRequest;
use App\Repositories\Application\ApplicationRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ApplicationController extends AppBaseController
{
    /** @var  ApplicationRepository */
    private $applicationRepository;

    public function __construct(ApplicationRepository $applicationRepo)
    {
        $this->applicationRepository = $applicationRepo;
    }

    /**
     * Display a listing of the Application.
     *
     * @param ApplicationDataTable $applicationDataTable
     * @return Response
     */
    public function index(ApplicationDataTable $applicationDataTable)
    {
        return $applicationDataTable->render('application.applications.index');
    }

    /**
     * Show the form for creating a new Application.
     *
     * @return Response
     */
    public function create()
    {
        return view('application.applications.create');
    }

    /**
     * Store a newly created Application in storage.
     *
     * @param CreateApplicationRequest $request
     *
     * @return Response
     */
    public function store(CreateApplicationRequest $request)
    {
        $input = $request->all();

        $application = $this->applicationRepository->create($input);

        Flash::success('Application saved successfully.');

        return redirect(route('application.applications.index'));
    }

    /**
     * Display the specified Application.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $application = $this->applicationRepository->find($id);

        if (empty($application)) {
            Flash::error('Application not found');

            return redirect(route('application.applications.index'));
        }

        return view('application.applications.show')->with('application', $application);
    }

    /**
     * Show the form for editing the specified Application.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $application = $this->applicationRepository->find($id);

        if (empty($application)) {
            Flash::error('Application not found');

            return redirect(route('application.applications.index'));
        }

        return view('application.applications.edit')->with('application', $application);
    }

    /**
     * Update the specified Application in storage.
     *
     * @param  int              $id
     * @param UpdateApplicationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateApplicationRequest $request)
    {
        $application = $this->applicationRepository->find($id);

        if (empty($application)) {
            Flash::error('Application not found');

            return redirect(route('application.applications.index'));
        }

        $application = $this->applicationRepository->update($request->all(), $id);

        Flash::success('Application updated successfully.');

        return redirect(route('application.applications.index'));
    }

    /**
     * Remove the specified Application from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $application = $this->applicationRepository->find($id);

        if (empty($application)) {
            Flash::error('Application not found');

            return redirect(route('application.applications.index'));
        }

        $this->applicationRepository->delete($id);

        Flash::success('Application deleted successfully.');

        return redirect(route('application.applications.index'));
    }
}
