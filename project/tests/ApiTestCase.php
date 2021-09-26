<?php

namespace Tests;

use App\Models\User;
use Codeception\Test\Unit as TestCase;

/**
 * Class ApiTestCase
 *
 * @package Tests
 */
class ApiTestCase extends TestCase
{
    /**
     * @var \ApiTester
     */
    protected $tester;

    /**
     * @var \App\Models\User
     */
    protected User $user;

    protected function _before()
    {
        $this->user = $this->createUser();

        foreach ($this->getHeaders() as $key => $value) {
            $this->tester->haveHttpHeader($key, $value);
        }
    }

    /**
     * Get headers for using in requests
     * @return string[]
     */
    public function getHeaders()
    {
        return [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->user->token,
        ];
    }

    /**
     * @return \App\Models\User
     */
    public function createUser()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $accessToken = $user->createToken('Personal Access Token');
        $user->token = $accessToken->plainTextToken;

        return $user;
    }
}
