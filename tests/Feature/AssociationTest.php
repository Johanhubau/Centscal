<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssociationTest extends TestCase
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
    }

    /**
     * Test the creation of the association.
     *
     * @return void
     */
    public function testStore()
    {

        $response = $this->postJson('/api/association', [
            'name' => 'Association',
            'color' => '#FFFFFF',
            'president_id' => '1'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);

    }

    public function testUnauthorizedStore()
    {
        $this->postJson('logout');

        $response = $this->postJson('/api/association', [
            'name' => 'Association',
            'color' => '#FFFFFF',
            'president_id' => '1'
        ]);

        dump($response);

        $response
            ->assertStatus(403)
            ->assertJson([
                'error' => 'User is unauthorized',
            ]);

    }

    /**
     * Test show association.
     *
     * @return void
     */
    public function testShow(){

        $this->postJson('/api/association', [
            'name' => 'Association',
            'color' => '#FFFFFF',
            'president_id' => '1'
        ]);

        $response = $this->getJson('/api/association/1');

        $response
            ->assertStatus(200);
    }

    /**
     * Test update association.
     *
     * @return void
     */
    public function testUpdate(){
        $this->postJson('/api/association', [
            'name' => 'Association',
            'color' => '#FFFFFF',
            'president_id' => '1'
        ]);

        $response = $this->postJson('/api/association/1', [
            'color' => '#FAFAFA'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'updated' => true,
            ]);

    }

    public function testUnauthorizedUpdate(){
        $this->postJson('/api/association', [
            'name' => 'Association',
            'color' => '#FFFFFF',
            'president_id' => '1'
        ]);

        $this->postJson('logout');

        $response = $this->postJson('/api/association/1', [
            'color' => '#FAFAFA'
        ]);

        $response
            ->assertStatus(403);

    }

    /**
     * Test the deletion of the association.
     *
     * @return void
     */
    public function testDelete(){
        $this->postJson('/api/association', [
            'name' => 'Association',
            'color' => '#FFFFFF',
            'president_id' => '1'
        ]);

        $response = $this->deleteJson('/api/association/1');

        $response
            ->assertStatus(200)
            ->assertJson([
                'deleted' => true
            ]);
    }

    public function testUnauthorizedDelete(){
        $this->postJson('/api/association', [
            'name' => 'Association',
            'color' => '#FFFFFF',
            'president_id' => '1'
        ]);

        $this->postJson('logout');

        $response = $this->deleteJson('/api/association/1');

        $response
            ->assertStatus(403);
    }
}
