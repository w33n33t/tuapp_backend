<?php namespace Tests\Traits;

use Faker\Factory as Faker;
use App\Models\Application\Application;
use App\Repositories\Application\ApplicationRepository;

trait MakeApplicationTrait
{
    /**
     * Create fake instance of Application and save it in database
     *
     * @param array $applicationFields
     * @return Application
     */
    public function makeApplication($applicationFields = [])
    {
        /** @var ApplicationRepository $applicationRepo */
        $applicationRepo = \App::make(ApplicationRepository::class);
        $theme = $this->fakeApplicationData($applicationFields);
        return $applicationRepo->create($theme);
    }

    /**
     * Get fake instance of Application
     *
     * @param array $applicationFields
     * @return Application
     */
    public function fakeApplication($applicationFields = [])
    {
        return new Application($this->fakeApplicationData($applicationFields));
    }

    /**
     * Get fake data of Application
     *
     * @param array $applicationFields
     * @return array
     */
    public function fakeApplicationData($applicationFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'text' => $fake->text,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s')
        ], $applicationFields);
    }
}
