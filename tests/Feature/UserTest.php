<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the creation of the user.
     *
     * @return void
     */
    public function testStore(){

        $response = $this->postJson('/api/user', [
            'first_name' => 'Sally',
            'last_name' => 'Smith',
            'email' => 'test@gmail.com',
            'password' => 'password',
            'c_password' => 'password'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);
    }

    /**
     * Test show user.
     *
     * @return void
     */
    public function testShow(){

        $this->postJson('/api/user', [
            'first_name' => 'Sally',
            'last_name' => 'Smith',
            'email' => 'test@gmail.com',
            'password' => 'password',
            'c_password' => 'password'
        ]);

        $response = $this->getJson('/api/user/1');

        $response
            ->assertStatus(200);
    }

    /**
     * Test update user.
     *
     * @return void
     */
    public function testUpdate(){
        $this->postJson('/api/user', [
            'first_name' => 'Sally',
            'last_name' => 'Smith',
            'email' => 'test@gmail.com',
            'password' => 'password',
            'c_password' => 'password'
        ]);

        $response = $this->postJson('/api/user/1', [
           'email' => 'nottest@gmail.com'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'updated' => true,
            ]);

    }

    /**
     * Test the deletion of the user.
     *
     * @return void
     */
    public function testDelete(){
        $this->postJson('/api/user', [
            'first_name' => 'Sally',
            'last_name' => 'Smith',
            'email' => 'test@gmail.com',
            'password' => 'password',
            'c_password' => 'password'
        ]);

        $response = $this->deleteJson('/api/user/1');

        dump($response);

        $response
            ->assertStatus(200)
            ->assertJson([
               'deleted' => true
            ]);
    }
}
