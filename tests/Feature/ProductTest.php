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

    public function test_client_get_a_product(){
        // Given
        //$product_id = 1;
        $product = factory(Product::class)->make();
        $product_id = $product->id;
        $product_name = $product->name;
        $product_price = $product->price;
        // When
        $url = "/api/products/".$product_id;
        $response = $this->json('GET', $url);

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(200);
        // Assert the response has the same data
        /*$response->assertExactJson([
            'data' => [
            'id' => $product_id,
            'name' => $product_name,
            'price' => $product_price
            ]
        ]);*/
    }

    //https://www.toptal.com/laravel/restful-laravel-api-tutorial


    /**
    * GET_PRODUCTS-1
    */      
    public function test_client_get_all_products()
    {
        // Given
        //a number of products
        $products = factory(Product::class, 5)->make();
        // When
        $response = $this->json('GET', '/api/products');

        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(200);


        /*$products_count = count($products) === length($response->data);
        $this->assertTrue($products_count);*/
    }

    /**
    * UPDATE-1
    */
    public function test_client_can_update_a_product(){
        //  Given
        //an existing products
        $product = factory(Product::class)->make();
        $product_id = $product->id;

        $newData = [
           'name' => 'Tacos',
            'price' => '200'
        ];
        //And there is a product with id in the application
        // When
        $url = '/api/products/'.$product_id;
        $response = $this->json('PUT', $url, $newData); 
        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(200); 
    }

    /**
    * DELETE-1
    */
    

    public function test_client_can_delete_a_product()
    {
        // Given
        //an existing product
        $product = factory(Product::class)->make();
        $product_id = $product->id;
        $product_name = $product->name;
        $product_price = $product->price;

        //-I send a request to delete the product
        $response = $this->json('DELETE', '/api/products/'.$product_id);

        // Then
        // Assert it sends the correct HTTP Status 204
        $response->assertNotFound();
        
        // Assert product isn't on the database
        $this->assertDatabaseMissing(
            'products',
            [
                'id' => $product_id,
                'name' => $product_name,
                'price' => $product_price
            ]
        );
    }
}