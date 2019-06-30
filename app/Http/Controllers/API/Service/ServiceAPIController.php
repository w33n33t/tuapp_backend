<?php

namespace App\Http\Controllers\API\Service;

use App\Http\Requests\API\Service\CreateServiceAPIRequest;
use App\Http\Requests\API\Service\UpdateServiceAPIRequest;
use App\Models\Service\Service;
use App\Repositories\Service\ServiceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;use Validator;

/**
 * Class ServiceController
 * @package App\Http\Controllers\API\Service
 */

class ServiceAPIController extends AppBaseController
{
    /** @var  ServiceRepository */
    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepo)
    {
        $this->serviceRepository = $serviceRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/services",
     *      summary="Get a listing of the Services.",
     *      tags={"Service"},
     *      description="Get all Services",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Service")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $services = $this->serviceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($services->toArray(), 'Services retrieved successfully');
    }

    /**
     * @param CreateServiceAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/services",
     *      summary="Store a newly created Service in storage",
     *      tags={"Service"},
     *      description="Store Service",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="title",
     *          in="body",
     *          description="Service that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Service")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Service"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateServiceAPIRequest $request)
    {
        $input = $request->all();

        $service = $this->serviceRepository->create($input);

        $service->app_id = ApplicationId();
        $service->save();

        return $this->sendResponse($service->toArray(), 'Service saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/services/{id}",
     *      summary="Display the specified Service",
     *      tags={"Service"},
     *      description="Get Service",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Service",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Service"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Service $service */
        $service = $this->serviceRepository->find($id);

        if (empty($service)) {
            return $this->sendError('Service not found');
        }

        return $this->sendResponse($service->toArray(), 'Service retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateServiceAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/services/{id}",
     *      summary="Update the specified Service in storage",
     *      tags={"Service"},
     *      description="Update Service",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Service",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Service that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Service")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Service"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateServiceAPIRequest $request)
    {
        $input = $request->all();

        /** @var Service $service */
        $service = $this->serviceRepository->find($id);

        if (empty($service)) {
            return $this->sendError('Service not found');
        }

        $service = $this->serviceRepository->update($input, $id);

        return $this->sendResponse($service->toArray(), 'Service updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/services/{id}",
     *      summary="Remove the specified Service from storage",
     *      tags={"Service"},
     *      description="Delete Service",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Service",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Service $service */
        $service = $this->serviceRepository->find($id);

        if (empty($service)) {
            return $this->sendError('Service not found');
        }

        $service->delete();

        return $this->sendResponse($id, 'Service deleted successfully');
    }
}
