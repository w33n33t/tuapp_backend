<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\Traits\MakeServiceTrait;
use Tests\ApiTestTrait;

class ServiceApiTest extends TestCase
{
    use MakeServiceTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_service()
    {
        $service = $this->fakeServiceData();
        $this->response = $this->json('POST', '/api/service/services', $service);

        $this->assertApiResponse($service);
    }

    /**
     * @test
     */
    public function test_read_service()
    {
        $service = $this->makeService();
        $this->response = $this->json('GET', '/api/service/services/'.$service->id);

        $this->assertApiResponse($service->toArray());
    }

    /**
     * @test
     */
    public function test_update_service()
    {
        $service = $this->makeService();
        $editedService = $this->fakeServiceData();

        $this->response = $this->json('PUT', '/api/service/services/'.$service->id, $editedService);

        $this->assertApiResponse($editedService);
    }

    /**
     * @test
     */
    public function test_delete_service()
    {
        $service = $this->makeService();
        $this->response = $this->json('DELETE', '/api/service/services/'.$service->id);

        $this->assertApiSuccess();
        $this->response = $this->json('GET', '/api/service/services/'.$service->id);

        $this->response->assertStatus(404);
    }
}
