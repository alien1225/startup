<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/parties/create', 'PartyController@create');
Route::get('/party/{partyId}', 'PartyController@party');
Route::get('/parties', 'PartyController@index');

Route::post('/parties/use/leave', 'PartyChannelController@leaveChannel');
Route::post('/parties/use/message', 'PartyChannelController@sendMessageChat');


/* TEST */
Route::post('/parties/test/update', 'TestPartyUpdateEventController@update');
Route::post('/parties/test/delete', 'TestPartyUpdateEventController@delete');
