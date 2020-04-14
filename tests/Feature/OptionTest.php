<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OptionTest extends TestCase
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
    }

    /**
     * Test the creation of the option.
     *
     * @return void
     */
    public function testStore(){

        $response = $this->postJson('/api/option', [
            'name' => 'Premium',
            'association_id' => '1'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);
    }

    /**
     * Test show option.
     *
     * @return void
     */
    public function testShow(){

        $this->postJson('/api/option', [
            'name' => 'Premium',
            'association_id' => '1'
        ]);

        $response = $this->getJson('/api/option/1');

        $response
            ->assertStatus(200);
    }

    /**
     * Test update option.
     *
     * @return void
     */
    public function testUpdate(){
        $this->postJson('/api/option', [
            'name' => 'Premium',
            'association_id' => '1'
        ]);

        $response = $this->postJson('/api/option/1', [
            'name' => 'Microphone'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'updated' => true,
            ]);

    }

    /**
     * Test the deletion of the option.
     *
     * @return void
     */
    public function testDelete(){
        $this->postJson('/api/option', [
            'name' => 'Premium',
            'association_id' => '1'
        ]);

        $response = $this->deleteJson('/api/option/1');

        $response
            ->assertStatus(200)
            ->assertJson([
                'deleted' => true
            ]);
    }
}
