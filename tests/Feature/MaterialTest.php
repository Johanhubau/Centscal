<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MaterialTest extends TestCase
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
     * Test the creation of the material.
     *
     * @return void
     */
    public function testStore(){

        $response = $this->postJson('/api/material', [
            'name' => 'Projector',
            'price' => 'Its Free',
            'association_id' => '1'
        ]);

        dump($response);

        $response
            ->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);
    }

    /**
     * Test show material.
     *
     * @return void
     */
    public function testShow(){

        $this->postJson('/api/material', [
            'name' => 'Projector',
            'price' => 'Its Free',
            'association_id' => '1'
        ]);

        $response = $this->getJson('/api/material/1');

        $response
            ->assertStatus(200);
    }

    /**
     * Test update material.
     *
     * @return void
     */
    public function testUpdate(){
        $this->postJson('/api/material', [
            'name' => 'Projector',
            'price' => 'Its Free',
            'association_id' => '1'
        ]);

        $response = $this->postJson('/api/material/1', [
            'name' => 'Microphone'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'updated' => true,
            ]);

    }

    /**
     * Test the deletion of the material.
     *
     * @return void
     */
    public function testDelete(){
        $this->postJson('/api/material', [
            'name' => 'Projector',
            'price' => 'Its Free',
            'association_id' => '1'
        ]);

        $response = $this->deleteJson('/api/material/1');

        $response
            ->assertStatus(200)
            ->assertJson([
                'deleted' => true
            ]);
    }
}
