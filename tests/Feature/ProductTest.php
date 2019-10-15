<?php
namespace Tests\Feature;
use App\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Console\Artisan;
class ProductTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
        //First, insert data into the test database; it uses a seeder of Products
        $this->artisan('db:seed',['--class'=>'ProductTableSeeder']);
    }
    /**
     * CREATE-1
     */
    public function test_client_can_create_a_product()
    {
        // Given data of a product
        $productData = [
            'name' => 'Product 3',
            'price' => '99.99'
        ];
        // When
        $response = $this->json('POST', '/api/products', $productData); 
        // Then
        // Assert if it sends the correct HTTP Status
        $response->assertStatus(201);
        // Assert if the response has the correct structure
        $response->assertJsonStructure([
            'id',
            'name',
            'price'
        ]);
        $body = $response->decodeResponseJson();
        // Assert the product was created with the correct data
        $response->assertJsonFragment([
            'id' => $body['id'],
            'name' => 'Product 3',
            'price' => '99.99'
        ]);
    }
    /**
     * CREATE-2
     */
    public function test_client_cannot_create_a_product_without_name(){
        // Given data without value of name (or without the attribute) of the product
        $productData = [
            'price' => '199.99'
        ];
        // When
        $response = $this->json('POST', '/api/products', $productData);
        
        // Then
        // Assert if it sends the correct HTTP Status
        $response->assertStatus(422);

        // Assert if the body of the answer contains the error, the title and the appropriate details for the error
        $response->assertJson(
            ['errors' => 
                [
                    [
                        'code' => 'ERROR-1',
                        'title' => 'Unprocessable Entity',
                        'detail' => 'The product name is neccesary'
                    ]
                ]
            ]
        );
        /*$response->assertJsonStructure([
            'errors'
        ]);*/
    }
    /**
     * CREATE-3
     */
    public function test_client_cannot_create_a_product_without_price(){
       // Given data without value of price (or without the attribute) of the product
       $productData = [
            'name' => 'Avocado'
        ];
        // When
        $response = $this->json('POST', '/api/products', $productData);
        
        // Then
        // Assert if it sends the correct HTTP Status
        $response->assertStatus(422);

        // Assert if the body of the answer contains the error, the title and the appropriate details for the error
        $response->assertJson(
            ['errors' => 
                [
                    [
                        'code' => 'ERROR-1',
                        'title' => 'Unprocessable Entity',
                        'detail' => 'The product price is neccesary'
                    ]
                ]
            ]
        ); 
    }
    /**
     * CREATE-4
     */
    public function test_client_cannot_create_a_product_if_price_is_not_numeric(){
        // Given data of one product, but the price is not numeric
        $productData = [
             'name' => 'Avocado',
             'price' => 's0'
         ];
 
         // When
         $response = $this->json('POST', '/api/products', $productData);
         
         // Then
         // Assert if it sends the correct HTTP Status
         $response->assertStatus(422);

         // Assert if the body of the answer contains the error, the title and the appropriate details for the error
         $response->assertJson(
             ['errors' => 
                [
                    [
                        'code' => 'ERROR-1',
                        'title' => 'Unprocessable Entity',
                        'detail' => 'The price should be numeric'
                    ]
                ]
             ]
         ); 
    }
    /**
     * CREATE-5
     */
    public function test_client_cannot_create_a_product_if_price_is_less_or_equal_than_zero(){
        // Given data of one product, but the price is less or equal than zero
        $productData = [
             'name' => 'Avocado',
             'price' => '-99.99'
         ];
 
         // When
         $response = $this->json('POST', '/api/products', $productData);
         
         // Then
         // Assert if it sends the correct HTTP Status
         $response->assertStatus(422);

         // Assert if the body of the answer contains the error, the title and the appropriate details for the error
         $response->assertJson(
             ['errors' => 
                [
                    [
                        'code' => 'ERROR-1',
                        'title' => 'Unprocessable Entity',
                        'detail' => 'The price must be greater than zero'
                    ]
                ]
             ]
         ); 
    }
    
    /**
     * UPDATE-1
     */
    public function test_client_can_update_a_product()
    {
        // Given data to update a product
        $product = factory(Product::class)->make();
        $id = $product->id;
        $newData = [
           'name' => 'Tacos',
            'price' => '200'
        ];
        // When
        $response = $this->json('PUT', '/api/products/'.$id, $productData); 
        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(200);
        // Assert if the response has the correct structure
        $response->assertJsonStructure([
            'id',
            'name',
            'price'
        ]);
        // Assert the product was update with the correct data
        $response->assertJsonFragment([
            'id' => $id,
            'name' => 'Tacos',
            'price' => '200'
        ]);
        
    }
    /**
     * UPDATE-2
    */
    public function test_client_cannot_update_a_product_if_the_price_is_not_numeric()
    {
        // Given data to update a product, but the price is not numeric
        $product = factory(Product::class)->make();
        $id =$product->id;
        $product->price = "S4";
        $productData = [
            'name' => $product->name,
            'price' => $product ->price
        ];
        // When
        $response = $this->json('PUT', '/api/products/'.$id, $productData); 
        // Then
        // Assert if it sends the correct HTTP Status
        $response->assertStatus(422);

        // Assert if the body of the answer contains the error, the title and the appropriate details for the error
        $response->assertJson(
            ['errors' => 
               [
                   [
                       'code' => 'ERROR-1',
                       'title' => 'Unprocessable Entity',
                       'detail' => 'The price should be numeric'
                   ]
               ]
            ]
        );  
    }
    /**
     * UPDATE-3
     */
    public function test_client_cannot_update_a_product_if_the_price_is_less_or_equal_than_zero()
    {
        // Given data to update a product, but the price is less or equal than zero
        $product = factory(Product::class)->make();
        $id =$product->id;
        $price = $product->price = "-55.34";
        $productData = [
            'name' => $product->name,
            'price' => $price
        ];
        // When
        $response = $this->json('PUT', '/api/products/'.$id, $productData); 
        // Then
        // Assert if it sends the correct HTTP Status
        $response->assertStatus(422);

        // Assert if the body of the answer contains the error, the title and the appropriate details for the error
        $response->assertJson(
            ['errors' => 
               [
                   [
                       'code' => 'ERROR-1',
                       'title' => 'Unprocessable Entity',
                       'detail' => 'The price must be greater than zero'
                   ]
               ]
            ]
        );  
    }
    /**
     * UPDATE-4
     */
    public function test_client_cannot_update_a_product_if_the_id_doesnt_exists()
    {
        // Given data to update a product
        $productData = [
            'name' => 'Avocado',
            'price' => '56.90'
        ];
        //And there is not a product with id = 10 in the application
        $id = 10;
        // When
        $response = $this->json('PUT', '/api/products/'.$id, $productData); 
        // Then
        // Assert if it sends the correct HTTP Status
        $response->assertStatus(404);

        // Assert if the body of the answer contains the error, the title and the appropriate details for the error
        $response->assertJson(
            ['errors' => 
               [
                   [
                       'code' => 'ERROR-2',
                       'title' => 'Not Found',
                       'detail' => 'There is not a product with the id: '.$id
                   ]
               ]
            ]
        );  
    }
    /**
     * SHOW-1
     */
    public function test_client_can_get_a_product()
    {
        // Given
        //There is a product in the application
        //$id = 2;
        $product = factory(Product::class)->make();
        $id = $product->id;
        $product_name = $product->name;
        $product_price = $product->price;
        // When
        $response = $this->json('GET', '/api/products/'.$id); 
        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(200);
        // Assert the response has the correct structure
        $response->assertJsonStructure([
            'id',
            'name',
            'price'
        ]);
        // Assert the product was returned with the correct data
        $response->assertJsonFragment([
            'id' => $id,
            'name' => $product_name,
            'price' => $product_price
        ]);
    }
    /**
     * SHOW-2
     */
    public function test_client_cant_get_a_product_if_the_id_dont_exists()
    {
        // Given
        //There is not a product with id = 17 in the application
        $id = 17;
        // When
        $response = $this->json('GET', '/api/products/'.$id); 
        // Then
        // Assert if it sends the correct HTTP Status
        $response->assertStatus(404);

        // Assert if the body of the answer contains the error, the title and the appropriate details for the error
        $response->assertJson(
            ['errors' => 
               [
                   [
                       'code' => 'ERROR-2',
                       'title' => 'Not Found',
                       'detail' => 'There is not a product with the id: '.$id
                   ]
               ]
            ]
        );  
    }
    /**
     * DELETE-1
     */
    public function test_client_can_delete_a_product()
    {
        // Given
        //There is a product with id = 1 in the application
        $id = 1;
        // When
        $response = $this->json('DELETE', '/api/products/'.$id); 
        // Then
        // Assert it sends the correct HTTP Status
        $response->assertStatus(204); 
    }
    /**
     * DELETE-2
     */
    public function test_client_cannot_delete_a_product_if_the_id_doesnt_exists()
    {
        // Given
        //There is not a product with id = 10 in the application
        $id = 10;
        // When
        $response = $this->json('DELETE', '/api/products/'.$id); 
        // Then
        // Assert if it sends the correct HTTP Status
        $response->assertStatus(404);

        // Assert if the body of the answer contains the error, the title and the appropriate details for the error
        $response->assertJson(
            ['errors' => 
               [
                   [
                       'code' => 'ERROR-2',
                       'title' => 'Not Found',
                       'detail' => 'There is not a product with the id: '.$id
                   ]
               ]
            ]
        );   
    }
    /**
     * LIST-1
     */
    public function test_client_can_get_all_the_products_if_there_are(){
        // Given 
        // There are products created
        // When
        $response = $this->json('GET', '/api/products'); 
        
        // Then
        // Assert if it sends the correct HTTP Status
        $response->assertStatus(200);
        // Assert if the response has the correct structure
        $response->assertJsonStructure(
            [
                [
                    'id',
                    'name',
                    'price'
                ]
            ]
        );
        // Assert the products were sent correctly
        $response->assertJson(Product::all()->toArray());
        
    }
    /**
     * LIST-2
     */
    public function test_client_can_get_no_products_if_there_are_not(){
        // Given 
        // There are not products created
        $this->artisan('migrate:refresh');
        // When
        $response = $this->json('GET', '/api/products'); 
        // Then
        // Assert if it sends the correct HTTP Status
        $response->assertStatus(200);
        // Assert if the response has the correct structure
        $response->assertJson(
            [
            ]
        );
    }
    public function tearDown(): void
    {
        //At the final, delete all the data in the test database
        $this->artisan('migrate:refresh');
        parent::tearDown();
    }
}