<?php namespace Tests\Repositories;

use App\Models\Application\Application;
use App\Repositories\Application\ApplicationRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\Traits\MakeApplicationTrait;
use Tests\ApiTestTrait;

class ApplicationRepositoryTest extends TestCase
{
    use MakeApplicationTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ApplicationRepository
     */
    protected $applicationRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->applicationRepo = \App::make(ApplicationRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_application()
    {
        $application = $this->fakeApplicationData();
        $createdApplication = $this->applicationRepo->create($application);
        $createdApplication = $createdApplication->toArray();
        $this->assertArrayHasKey('id', $createdApplication);
        $this->assertNotNull($createdApplication['id'], 'Created Application must have id specified');
        $this->assertNotNull(Application::find($createdApplication['id']), 'Application with given id must be in DB');
        $this->assertModelData($application, $createdApplication);
    }

    /**
     * @test read
     */
    public function test_read_application()
    {
        $application = $this->makeApplication();
        $dbApplication = $this->applicationRepo->find($application->id);
        $dbApplication = $dbApplication->toArray();
        $this->assertModelData($application->toArray(), $dbApplication);
    }

    /**
     * @test update
     */
    public function test_update_application()
    {
        $application = $this->makeApplication();
        $fakeApplication = $this->fakeApplicationData();
        $updatedApplication = $this->applicationRepo->update($fakeApplication, $application->id);
        $this->assertModelData($fakeApplication, $updatedApplication->toArray());
        $dbApplication = $this->applicationRepo->find($application->id);
        $this->assertModelData($fakeApplication, $dbApplication->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_application()
    {
        $application = $this->makeApplication();
        $resp = $this->applicationRepo->delete($application->id);
        $this->assertTrue($resp);
        $this->assertNull(Application::find($application->id), 'Application should not exist in DB');
    }
}
