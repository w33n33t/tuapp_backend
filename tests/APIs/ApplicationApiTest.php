<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\Traits\MakeApplicationTrait;
use Tests\ApiTestTrait;

class ApplicationApiTest extends TestCase
{
    use MakeApplicationTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_application()
    {
        $application = $this->fakeApplicationData();
        $this->response = $this->json('POST', '/api/application/applications', $application);

        $this->assertApiResponse($application);
    }

    /**
     * @test
     */
    public function test_read_application()
    {
        $application = $this->makeApplication();
        $this->response = $this->json('GET', '/api/application/applications/'.$application->id);

        $this->assertApiResponse($application->toArray());
    }

    /**
     * @test
     */
    public function test_update_application()
    {
        $application = $this->makeApplication();
        $editedApplication = $this->fakeApplicationData();

        $this->response = $this->json('PUT', '/api/application/applications/'.$application->id, $editedApplication);

        $this->assertApiResponse($editedApplication);
    }

    /**
     * @test
     */
    public function test_delete_application()
    {
        $application = $this->makeApplication();
        $this->response = $this->json('DELETE', '/api/application/applications/'.$application->id);

        $this->assertApiSuccess();
        $this->response = $this->json('GET', '/api/application/applications/'.$application->id);

        $this->response->assertStatus(404);
    }
}
