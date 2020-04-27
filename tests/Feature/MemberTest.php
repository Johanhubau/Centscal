<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MemberTest extends TestCase
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
     * Test the creation of the member.
     *
     * @return void
     */
    public function testStore(){

        $response = $this->postJson('/api/member', [
            'role' => 'SUPER_ADMIN',
            'user_id' => '1',
            'association_id' => '1'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);
    }

    public function testUnauthorizedStore(){

        $this->postJson('logout');

        $response = $this->postJson('/api/member', [
            'role' => 'SUPER_ADMIN',
            'user_id' => '1',
            'association_id' => '1'
        ]);

        $response
            ->assertStatus(403)
            ->assertJson(['error'=>'User is unauthorized']);
    }

    /**
     * Test show member.
     *
     * @return void
     */
    public function testShow(){

        $this->postJson('/api/member', [
            'role' => 'SUPER_ADMIN',
            'user_id' => '1',
            'association_id' => '1'
        ]);

        $response = $this->getJson('/api/member/1');

        $response
            ->assertStatus(200);
    }

    /**
     * Test update member.
     *
     * @return void
     */
    public function testUpdate(){
        $this->postJson('/api/member', [
            'role' => 'SUPER_ADMIN',
            'user_id' => '1',
            'association_id' => '1'
        ]);

        $response = $this->postJson('/api/member/1', [
            'desc' => 'Microphone'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'updated' => true,
            ]);

    }

    public function testUnauthorizedUpdate(){
        $this->postJson('/api/member', [
            'role' => 'SUPER_ADMIN',
            'user_id' => '1',
            'association_id' => '1'
        ]);

        $this->postJson('logout');

        $response = $this->postJson('/api/member/1', [
            'desc' => 'Microphone'
        ]);

        $response
            ->assertStatus(403);

    }

    /**
     * Test the deletion of the member.
     *
     * @return void
     */
    public function testDelete(){
        $this->postJson('/api/member', [
            'role' => 'SUPER_ADMIN',
            'user_id' => '1',
            'association_id' => '1'
        ]);

        $response = $this->deleteJson('/api/member/1');

        $response
            ->assertStatus(200)
            ->assertJson([
                'deleted' => true
            ]);
    }

    public function testUnauthorizedDelete(){
        $this->postJson('/api/member', [
            'role' => 'SUPER_ADMIN',
            'user_id' => '1',
            'association_id' => '1'
        ]);

        $this->postJson('logout');

        $response = $this->deleteJson('/api/member/1');

        $response
            ->assertStatus(403);
    }
}
