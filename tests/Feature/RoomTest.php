<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoomTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->postJson('/api/user', [
            'first_name' => 'Sally',
            'last_name' => 'Smith',
            'email' => 'test@gmail.com',
            'password' => 'password',
            'c_password' => 'password',
            'role' => 'ROLE_ADMIN'
        ]);

        $this->postJson('login', [
            'email' => 'test@gmail.com',
            'password' => 'password'
        ]);

        $this->postJson('/api/association', [
            'name' => 'Association',
            'color' => '#FFFFFF',
            'president_id' => '1'
        ]);
    }

    /**
     * Test the creation of the room.
     *
     * @return void
     */
    public function testStore(){

        $response = $this->postJson('/api/room', [
            'name' => 'B201',
            'owner_id' => '1'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);
    }

    public function testUnauthorisedStore(){

        $this->postJson('logout');

        $response = $this->postJson('/api/room', [
            'name' => 'B201',
            'owner_id' => '1'
        ]);

        $response
            ->assertStatus(403)
            ->assertJson(['error'=>'User is unauthorized']);
    }

    /**
     * Test show room.
     *
     * @return void
     */
    public function testShow(){

        $this->postJson('/api/room', [
            'name' => 'B201',
            'owner_id' => '1'
        ]);

        $response = $this->getJson('/api/room/1');

        $response
            ->assertStatus(200);
    }

    /**
     * Test update room.
     *
     * @return void
     */
    public function testUpdate(){
        $this->postJson('/api/room', [
            'name' => 'B201',
            'owner_id' => '1'
        ]);

        $response = $this->postJson('/api/room/1', [
            'name' => 'G07'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'updated' => true,
            ]);

    }

    public function testUnauthorisedUpdate(){
        $this->postJson('/api/room', [
            'name' => 'B201',
            'owner_id' => '1'
        ]);

        $this->postJson('logout');

        $response = $this->postJson('/api/room/1', [
            'name' => 'G07'
        ]);

        $response
            ->assertStatus(403);

    }

    /**
     * Test the deletion of the room.
     *
     * @return void
     */
    public function testDelete(){
        $this->postJson('/api/room', [
            'name' => 'B201',
            'owner_id' => '1'
        ]);

        $response = $this->deleteJson('/api/room/1');

        $response
            ->assertStatus(200)
            ->assertJson([
                'deleted' => true
            ]);
    }

    public function testUnauthorisedDelete(){
        $this->postJson('/api/room', [
            'name' => 'B201',
            'owner_id' => '1'
        ]);

        $this->postJson('logout');

        $response = $this->deleteJson('/api/room/1');

        $response
            ->assertStatus(403);
    }
}
