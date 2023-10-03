<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Enums\OrderStatusEnums;
use App\Enums\UserRoleEnums;
use App\Models\Option;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Variation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ExampleTest extends TestCase
{

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        Artisan::call('passport:install');
    }


    /**
     * @return void
     */
    public function test_user_login(): void
    {
        $user = User::first();
        $response = $this->post('/api/login',
            [
                'email'    => $user->email,
                'password' => 'password'
            ]);
        $response->assertStatus(Response::HTTP_OK);
        $content = json_decode($response->content());
        $this->assertEquals($content->message, trans('auth.login'));
    }


    /**
     * @return void
     */
    public function test_user_failed_login(): void
    {
        $response = $this->post('/api/login',
            [
                'email'    => 'ad@gmail.com',
                'password' => '456879'
            ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $content = json_decode($response->content());
        $this->assertEquals($content->message, trans('auth.failed'));
    }


    /**
     * @return void
     */
    public function test_shop_view_products_list(): void
    {
        $user = User::first();
        $loginResponse = $this->post('/api/login',
            [
                'email'    => $user->email,
                'password' => 'password'
            ]);
        $loginResponseContent = json_decode($loginResponse->content());
        $response = $this->get('/api/products', [
            'Authorization' => 'Bearer ' . $loginResponseContent->data->token
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }


    /**
     * @return void
     */
    public function test_shop_view_product(): void
    {
        $user = User::first();
        $loginResponse = $this->post('/api/login',
            [
                'email'    => $user->email,
                'password' => 'password'
            ]);
        $loginResponseContent = json_decode($loginResponse->content());
        $response = $this->get('/api/products/1', [
            'Authorization' => 'Bearer ' . $loginResponseContent->data->token
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }


    /**
     * @return void
     */
    public function test_shop_view_orders_list(): void
    {
        $user = User::first();
        $loginResponse = $this->post('/api/login',
            [
                'email'    => $user->email,
                'password' => 'password'
            ]);
        $loginResponseContent = json_decode($loginResponse->content());
        $response = $this->get('/api/orders', [
            'Authorization' => 'Bearer ' . $loginResponseContent->data->token
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }


    /**
     * @return void
     */
    public function test_shop_view_order(): void
    {
        $order = Order::first();
        $user = User::find($order->user_id);
        $loginResponse = $this->post('/api/login',
            [
                'email'    => $user->email,
                'password' => 'password'
            ]);
        $loginResponseContent = json_decode($loginResponse->content());
        $response = $this->get('/api/orders/' . $order->id, [
            'Authorization' => 'Bearer ' . $loginResponseContent->data->token
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }


    /**
     * @return void
     */
    public function test_shop_store_order(): void
    {
        $user = User::first();
        $loginResponse = $this->post('/api/login',
            [
                'email'    => $user->email,
                'password' => 'password'
            ]);
        $loginResponseContent = json_decode($loginResponse->content());
        $response = $this->post('/api/orders', [
            'product_id' => Product::first()->id,
            'variations' => [
                "0" => [
                    "id"        => 1,
                    "option_id" => 1
                ]
            ]
        ], [
            'Authorization' => 'Bearer ' . $loginResponseContent->data->token
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
    }


    /**
     * @return void
     */
    public function test_shop_update_order(): void
    {
        $order = Order::first();
        $user = User::find($order->user_id);
        $loginResponse = $this->post('/api/login',
            [
                'email'    => $user->email,
                'password' => 'password'
            ]);
        $loginResponseContent = json_decode($loginResponse->content());
        $response = $this->put('/api/orders/' . $order->id, [
            'product_id' => Product::first()->id,
            'variations' => [
                "0" => [
                    "id"        => 1,
                    "option_id" => 1
                ]
            ]
        ], [
            'Authorization' => 'Bearer ' . $loginResponseContent->data->token
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }


    /**
     * @return void
     */
    public function test_admin_view_orders_list()
    {
        $adminUser = User::where('role', UserRoleEnums::ADMIN->value)->first();
        $loginResponse = $this->post('/api/login',
            [
                'email'    => $adminUser->email,
                'password' => 'password'
            ]);
        $loginResponseContent = json_decode($loginResponse->content());
        $response = $this->get('/api/admin/orders', [
            'Authorization' => 'Bearer ' . $loginResponseContent->data->token
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }


    /**
     * @return void
     */
    public function test_admin_view_order()
    {
        $adminUser = User::where('role', UserRoleEnums::ADMIN->value)->first();
        $loginResponse = $this->post('/api/login',
            [
                'email'    => $adminUser->email,
                'password' => 'password'
            ]);
        $loginResponseContent = json_decode($loginResponse->content());
        $response = $this->get('/api/admin/orders/1', [
            'Authorization' => 'Bearer ' . $loginResponseContent->data->token
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }


    /**
     * @return void
     */
    public function test_admin_update_order()
    {
        $adminUser = User::where('role', UserRoleEnums::ADMIN->value)->first();
        $loginResponse = $this->post('/api/login',
            [
                'email'    => $adminUser->email,
                'password' => 'password'
            ]);
        $loginResponseContent = json_decode($loginResponse->content());
        $response = $this->put('/api/admin/orders/1',
            [
                'status' => 'cancel'
            ], [
                'Authorization' => 'Bearer ' . $loginResponseContent->data->token
            ]);
        $response->assertStatus(Response::HTTP_OK);
    }


    /**
     * @return void
     */
    public function test_admin_delete_order()
    {
        $adminUser = User::where('role', UserRoleEnums::ADMIN->value)->first();
        $loginResponse = $this->post('/api/login',
            [
                'email'    => $adminUser->email,
                'password' => 'password'
            ]);
        $loginResponseContent = json_decode($loginResponse->content());
        $response = $this->delete('/api/admin/orders/1', [], [
            'Authorization' => 'Bearer ' . $loginResponseContent->data->token
        ]);
        $this->assertEquals(null, Order::find(1));
        $response->assertStatus(Response::HTTP_OK);
    }


    /**
     * @return void
     */
    public function test_no_admin_user_can_not_access_to_admin_panel(): void
    {
        $adminUser = User::where('role', UserRoleEnums::CUSTOMER->value)->first();
        $loginResponse = $this->post('/api/login',
            [
                'email'    => $adminUser->email,
                'password' => 'password'
            ]);
        $loginResponseContent = json_decode($loginResponse->content());
        $response = $this->get('/api/admin/orders/1', [
            'Authorization' => 'Bearer ' . $loginResponseContent->data->token
        ]);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }


    /**
     * @return void
     */
    public function test_admin_view_products_list(): void
    {
        $adminUser = User::where('role', UserRoleEnums::ADMIN->value)->first();
        $loginResponse = $this->post('/api/login',
            [
                'email'    => $adminUser->email,
                'password' => 'password'
            ]);
        $loginResponseContent = json_decode($loginResponse->content());
        $response = $this->get('/api/admin/products', [
            'Authorization' => 'Bearer ' . $loginResponseContent->data->token
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }


    /**
     * @return void
     */
    public function test_admin_view_product(): void
    {
        $adminUser = User::where('role', UserRoleEnums::ADMIN->value)->first();
        $loginResponse = $this->post('/api/login',
            [
                'email'    => $adminUser->email,
                'password' => 'password'
            ]);
        $loginResponseContent = json_decode($loginResponse->content());
        $response = $this->get('/api/admin/products/1', [
            'Authorization' => 'Bearer ' . $loginResponseContent->data->token
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }


    /**
     * @return void
     */
    public function test_admin_store_product(): void
    {
        $adminUser = User::where('role', UserRoleEnums::ADMIN->value)->first();
        $loginResponse = $this->post('/api/login',
            [
                'email'    => $adminUser->email,
                'password' => 'password'
            ]);
        $loginResponseContent = json_decode($loginResponse->content());
        $response = $this->post('/api/admin/products',
            [
                'title'      => 'sample product',
                'price'      => 30,
                'variations' => [
                    0 => [
                        'id'        => '1',
                        'option_id' => 1
                    ]
                ]
            ], [
                'Authorization' => 'Bearer ' . $loginResponseContent->data->token
            ]);
        $response->assertStatus(Response::HTTP_CREATED);
    }


    /**
     * @return void
     */
    public function test_admin_update_product(): void
    {
        $adminUser = User::where('role', UserRoleEnums::ADMIN->value)->first();
        $loginResponse = $this->post('/api/login',
            [
                'email'    => $adminUser->email,
                'password' => 'password'
            ]);
        $loginResponseContent = json_decode($loginResponse->content());
        $response = $this->put('/api/admin/products/1',
            [
                'title'      => 'sample product',
                'price'      => 30,
                'variations' => [
                    0 => [
                        'id'        => '1',
                        'option_id' => 1
                    ]
                ]
            ], [
                'Authorization' => 'Bearer ' . $loginResponseContent->data->token
            ]);
        $response->assertStatus(Response::HTTP_OK);
    }


    /**
     * @return void
     */
    public function test_admin_delete_product(): void
    {
        $adminUser = User::where('role', UserRoleEnums::ADMIN->value)->first();
        $loginResponse = $this->post('/api/login',
            [
                'email'    => $adminUser->email,
                'password' => 'password'
            ]);
        $loginResponseContent = json_decode($loginResponse->content());
        $response = $this->delete('/api/admin/products/1', [], [
            'Authorization' => 'Bearer ' . $loginResponseContent->data->token
        ]);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }


    /**
     * @return void
     */
    public function test_models_relations(): void
    {
        // variation relations
        $variation = Variation::first();
        $this->assertInstanceOf(BelongsToMany::class, $variation->products());
        $this->assertInstanceOf(BelongsToMany::class, $variation->options());

        // product relations
        $product = Product::first();
        $this->assertInstanceOf(HasMany::class, $product->orders());
        $this->assertInstanceOf(BelongsToMany::class, $product->variations());

        // option relations
        $option = Option::first();
        $this->assertInstanceOf(BelongsToMany::class, $option->variations());

        // order relations
        $order = Order::first();
        $this->assertInstanceOf(BelongsTo::class, $order->user());
        $this->assertInstanceOf(BelongsTo::class, $order->product());

        // user relations
        $user = User::first();
        $this->assertInstanceOf(HasMany::class, $user->orders());
    }
}
