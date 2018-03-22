<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('/login', ['as' => 'login', 'uses' => 'Auth\LoginController@login']);
    $router->post('/register', ['as' => 'register', 'uses' => 'Auth\RegisterController@register']);

    $router->post('/alternative-login', ['as' => 'alternative_login', 'uses' => 'Auth\AlternativeLoginController@checkUser']);

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->group(['middleware' => 'role:customer'], function () use ($router) {
            $router->post('/get-categories', ['as' => 'customer.get_categories', 'uses' => 'CategoryController@getCategories']);
            $router->post('/get-events', ['as' => 'customer.get_events', 'uses' => 'CustomerController@getEvents']);
            $router->post('/get-goods', ['as' => 'customer.get_goods', 'uses' => 'GoodController@getGoods']);
            $router->post('/get-basket-goods', ['as' => 'customer.get_basket_goods', 'uses' => 'BasketGoodsController@getBasketGoods']);

            $router->group(['middleware' => 'basket:basket_unfinished'], function () use ($router) {
                $router->post('/get-basket', ['as' => 'customer.get_basket', 'uses' => 'BasketController@getBasket']);
                $router->post('/get-good-in-basket', ['as' => 'customer.get_good_in_basket', 'uses' => 'BasketGoodsController@getGoodInBasket']);
                $router->post('/buy-goods', ['as' => 'customer.buy_goods', 'uses' => 'GoodController@buyGoods']);
            });

            /*$router->group(['middleware' => 'profile'], function () use ($router) {
            });*/

            $router->post('/get-main-profile', ['as' => 'customer.get_main_profile', 'uses' => 'CustomerController@getMainProfile']);
            $router->post('/get-main-address', ['as' => 'customer.get_main_address', 'uses' => 'CustomerController@getMainAddress']);
            $router->post('/get-all-addresses', ['as' => 'customer.get_all_addresses', 'uses' => 'CustomerController@getAllAddresses']);
            $router->post('/post-delete-address', ['as' => 'customer.post_delete_address', 'uses' => 'CustomerController@postDeleteAddress']);

            $router->post('/get-payment-method', ['as' => 'customer.get_payment_method', 'uses' => 'CustomerController@getPaymentMethod']);
        });

//        $router->group(['middleware' => 'role:admin'], function () use ($router) {
        $router->post('/upload-file', ['as' => 'admin.upload_file', 'uses' => 'Admin\AdminController@uploadFile']);
//        });
    });
});