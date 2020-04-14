<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RentTest extends TestCase
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
            'c_password' => 'password'
        ]);

        $this->postJson('/api/association', [
            'name' => 'Association',
            'color' => '#FFFFFF',
            'president_id' => '1'
        ]);

        $this->postJson('/api/event', [
            'title' => 'Party',
            'begin' => '2019-12-07 15:00:00',
            'end' => '2019-12-07 15:00:00',
            'association_id' => '1'
        ]);

        $this->postJson('/api/material', [
            'name' => 'Microphone',
            'price' => '20 dollars/day',
            'association_id' => '1'
        ]);
    }

    /**
     * Test the creation of the rent.
     *
     * @return void
     */
    public function testStore(){

        $response = $this->postJson('/api/rent', [
            'material_id' => '1',
            'event_id' => '1'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);
    }

    /**
     * Test show rent.
     *
     * @return void
     */
    public function testShow(){

        $this->postJson('/api/rent', [
            'material_id' => '1',
            'event_id' => '1'
        ]);

        $response = $this->getJson('/api/rent/1');

        $response
            ->assertStatus(200);
    }

    /**
     * Test update rent.
     *
     * @return void
     */
    public function testUpdate(){
        $this->postJson('/api/rent', [
            'material_id' => '1',
            'event_id' => '1'
        ]);

        $response = $this->postJson('/api/rent/1', [
            'approved' => true
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'updated' => true,
            ]);

    }

    /**
     * Test the deletion of the rent.
     *
     * @return void
     */
    public function testDelete(){
        $this->postJson('/api/rent', [
            'material_id' => '1',
            'event_id' => '1'
        ]);

        $response = $this->deleteJson('/api/rent/1');

        $response
            ->assertStatus(200)
            ->assertJson([
                'deleted' => true
            ]);
    }
}
