<?php

namespace Tests\Feature;

use App\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    /**
     * CREATE-1
     */    
    public function test_client_can_create_a_product()
    {
        // Given
        $productData = [
            'name' => 'Super Product',
            'price' => '23.30'
        ];

        // When
        $response = $this->json('POST', '/api/products', $productData); 

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(201);
        
        // Assert the response has the correct structure
        $response->assertJsonStructure([
            'id',
            'name',
            'price'
        ]);

        // Assert the product was created
        // with the correct data
        $response->assertJsonFragment([
            'name' => 'Super Product',
            'price' => '23.30'
        ]);
        
        $body = $response->decodeResponseJson();

        // Assert product is on the database
        $this->assertDatabaseHas(
            'products',
            [
                'id' => $body['id'],
                'name' => 'Super Product',
                'price' => '23.30'
            ]
        );
    }

    /**
    * GET_A_PRODUCT-1
    */    
    public function test_client_get_a_product()
    {
        // Given
        $product_id = 1;

        // Assert product is on the database
        /*$this->assertDatabaseHas(
            'products',
            [
                'id' => $product_id,
                'name' => 'Other class homework',
                'price' => '20.10'
            ]
        );*/

        // When
        $response = $this->json('GET', '/api/products/1');



        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(200);
        
        // Assert the response has the correct structure
        /*$response->assertJsonStructure([
            'id',
            'name',
            'price'
        ]);*/

        // Assert the product is returned                 //was created
        // with the correct data
        /*$response->assertJsonFragment([
            'name' => 'Super Product',
            'price' => '23.30'
        ]);*/
    }
    //https://www.toptal.com/laravel/restful-laravel-api-tutorial


    /**
    * GET_PRODUCTS-1
    */      
    public function test_client_get_all_products()
    {
        // Given

        // Assert product is on the database
        /*$this->assertDatabaseHas(
            'products',
            [
                'id' => $product_id,
                'name' => 'Super Product',
                'price' => '23.30'
            ]
        );*/

        // When
        $response = $this->json('GET', '/api/products');



        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(200);
        
        // Assert the response has the correct structure
        /*$response->assertJsonStructure([
            'id',
            'name',
            'price'
        ]);*/

        // Assert the product is returned                 //was created
        // with the correct data
        /*$response->assertJsonFragment([
            'name' => 'Super Product',
            'price' => '23.30'
        ]);*/
    }

    /**
    * UPDATE-1
    */     
    public function test_client_update_a_product()
    {
        // Given

        // Assert product is on the database
        /*$this->assertDatabaseHas(
            'products',
            [
                'id' => $product_id,
                'name' => 'Super Product',
                'price' => '23.30'
            ]
        );*/

        // When
        $response = $this->json('PUT', '/api/products');

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(200);
        
        // Assert the response has the correct structure
        /*$response->assertJsonStructure([
            'id',
            'name',
            'price'
        ]);*/

        // Assert the product is returned                 //was created
        // with the correct data
        /*$response->assertJsonFragment([
            'name' => 'Super Product',
            'price' => '23.30'
        ]);*/
    }

    /**
    * DELETE-1
    */     
    public function test_client_can_delete_a_product()
    {
        // Given
        // Given
        $productData = [
            'name' => 'Super Product',
            'price' => '23.30'
        ];

        // When
        $response1 = $this->json('POST', '/api/products', $productData); 
        $body = $response1->decodeResponseJson();
        $id = $body['id'];

        // When
        $response = $this->json('DELETE', '/api/products/'.$id);

        // Then
        // Assert it sends the correct HTTP Status
        //$response->assertStatus(204);
        $response->assertStatus(200);
        
        // Assert product isn't on the database
        $this->assertDatabaseMissing(
            'products',
            [
                'id' => $id,
                'name' => 'Other class homework',
                'price' => '20.10'
            ]
        );
    }
    
}