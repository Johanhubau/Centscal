<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventTest extends TestCase
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

        $this->postJson('/en/login', [
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
     * Test the creation of the event.
     *
     * @return void
     */
    public function testStore(){

        $response = $this->postJson('/api/event', [
            'title' => 'Party',
            'begin' => '2019-12-07 15:00:00',
            'end' => '2019-12-07 16:00:00',
            'association_id' => '1'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);
    }

    public function testUnauthorizedStore(){

        $this->postJson('/en/logout');

        $response = $this->postJson('/api/event', [
            'title' => 'Party',
            'begin' => '2019-12-07 15:00:00',
            'end' => '2019-12-07 16:00:00',
            'association_id' => '1'
        ]);

        $response
            ->assertStatus(403)
            ->assertJson([
                'error' => 'User is unauthorized',
            ]);
    }

    /**
     * Test show event.
     *
     * @return void
     */
    public function testShow(){

        $this->postJson('/api/event', [
            'title' => 'Party',
            'begin' => '2019-12-07 15:00:00',
            'end' => '2019-12-07 15:00:00',
            'association_id' => '1'
        ]);

        $response = $this->getJson('/api/event/1');

        $response
            ->assertStatus(200);
    }

    /**
     * Test update event.
     *
     * @return void
     */
    public function testUpdate(){

        $this->postJson('/api/event', [
            'title' => 'Party',
            'begin' => '2019-12-07 15:00:00',
            'end' => '2019-12-07 15:00:00',
            'association_id' => '1'
        ]);

        $response = $this->postJson('/api/event/1', [
            'name' => 'G07'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'updated' => true,
            ]);

    }

    public function testUnauthorizedUpdate(){

        $this->postJson('/api/event', [
            'title' => 'Party',
            'begin' => '2019-12-07 15:00:00',
            'end' => '2019-12-07 15:00:00',
            'association_id' => '1'
        ]);

        $this->postJson('/en/logout');

        $response = $this->postJson('/api/event/1', [
            'name' => 'G07'
        ]);

        $response
            ->assertStatus(403);
    }

    /**
     * Test the deletion of the event.
     *
     * @return void
     */
    public function testDelete(){
        $this->postJson('/api/event', [
            'title' => 'Party',
            'begin' => '2019-12-07 15:00:00',
            'end' => '2019-12-07 15:00:00',
            'association_id' => '1'
        ]);

        $response = $this->deleteJson('/api/event/1');

        $response
            ->assertStatus(200)
            ->assertJson([
                'deleted' => true
            ]);
    }

    public function testUnauthorizedDelete(){
        $this->postJson('/api/event', [
            'title' => 'Party',
            'begin' => '2019-12-07 15:00:00',
            'end' => '2019-12-07 15:00:00',
            'association_id' => '1'
        ]);

        $this->postJson('/en/logout');

        $response = $this->deleteJson('/api/event/1');

        $response
            ->assertStatus(403);
    }
}
