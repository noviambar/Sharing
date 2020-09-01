<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', function(){
    if (auth()->check()){
        return redirect()->route('home');
    }else{
        return redirect('login');
    }
});

Route::get('/meeting','MeetingController@meeting')->name('meeting');
Route::get('/meeting/getMeeting', 'MeetingController@getMeeting')->name('meeting.getMeeting');
Route::get('/meeting/show/{id}', 'MeetingController@show')->name('meeting.show');
Route::get('/meeting/edit/{id}', 'MeetingController@edit')->name('meeting.edit');
Route::post('/meeting/edit/{id}', 'MeetingController@update')->name('meeting.update');
Route::get('/meeting/delete/{id}', 'MeetingController@delete')->name('meeting.delete');
Route::delete('/meeting/delete/{id}', 'MeetingController@destroy')->name('meeting.destroy');

Route::get('/training','TrainingController@training')->name('training');
Route::get('/training/getTraining','TrainingController@getTraining')->name('training.getTraining');
Route::get('/training/show/{id}', 'TrainingController@show')->name('training.show');
Route::get('/training/show/download/{id}', 'TrainingController@download')->name('training.show.download');
Route::get('/training/edit/{id}', 'TrainingController@edit')->name('training.edit');
Route::post('/training/edit/{id}', 'TrainingController@update')->name('training.update');
Route::get('/training/delete/{id}', 'TrainingController@delete')->name('training.delete');
Route::delete('/training/delete/{id}', 'TrainingController@destroy')->name('training.destroy');


Route::get('/upload','UploadController@createForm');
Route::post('/upload','UploadController@uploadfile')->name('uploadFile');

Route::get('/content','ContentController@createForm')->name('content');
Route::post('/content','ContentController@uploadcontent')->name('uploadContent');

Route::get('/content/training','ContentController@createFormTraining')->name('createFormTraining');
Route::post('/content/training','ContentController@uploadtraining')->name('uploadTraining');

Route::get('/logproblem','LogController@logproblem')->name('logproblem');

Route::get('/register','RegisterController@register')->name('register');
Route::post('/postRegister','RegisterController@postRegister')->name('postRegister');


Route::get('/profile','ProfileController@profile')->name('profile');
Route::get('/trash','ProfileController@trash')->name('trash');
Route::get('/profile/getProfile','ProfileController@getProfile')->name('profile.getProfile');
Route::get('/profile/getTrash','ProfileController@getTrash')->name('profile.getTrash');
Route::get('/profile/delete/{id}', 'ProfileController@delete')->name('profile.delete');
Route::get('/profile/restore/{id}', 'ProfileController@restore')->name('profile.restore');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/edit/{id}', 'HomeController@edit')->name('home.edit');
Route::post('/home/edit/{id}', 'HomeController@update')->name('home.update');

Route::get('/logActivity/getActivity', 'MeetingController@getActivity')->name('logActivity.getActivity');
Route::get('/logActivity', 'MeetingController@logActivity')->name('logActivity');
