<?php

use App\ActivityUser;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
Route::get('/', function(Request $request){
    $remember = $request->remember ? true : false;

    $up = $request->only('email','password');

    if (\Illuminate\Support\Facades\Auth::attempt($up, $remember)){
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
Route::get('/trashmeeting','MeetingController@trashmeeting')->name('trashmeeting');
Route::get('/meeting/getTrash','MeetingController@getTrash')->name('meeting.getTrash');
Route::get('/meeting/delete/{id}', 'MeetingController@delete')->name('meeting.delete');
Route::get('/meeting/restore/{id}', 'MeetingController@restore')->name('meeting.restore');

Route::get('/training','TrainingController@training')->name('training');
Route::get('/training/getTraining','TrainingController@getTraining')->name('training.getTraining');
Route::get('/training/show/{id}', 'TrainingController@show')->name('training.show');
Route::get('/training/show/download/{id}', 'TrainingController@download')->name('training.show.download');
Route::get('/training/edit/{id}', 'TrainingController@edit')->name('training.edit');
Route::post('/training/edit/{id}', 'TrainingController@update')->name('training.update');
Route::get('/trashtraining','TrainingController@trashtraining')->name('trashtraining');
Route::get('/training/getTrash','TrainingController@getTrash')->name('training.getTrash');
Route::get('/training/delete/{id}', 'TrainingController@delete')->name('training.delete');
Route::get('/training/restore/{id}', 'TrainingController@restore')->name('training.restore');



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
Route::get('home/edit/{id}', 'HomeController@edit')->name('home.edit');
Route::post('home/edit/{id}','HomeController@update')->name('home.update');

Route::group(['middleware' => 'auth'], function (){
    Route::get('home/editPassword', 'HomeController@editPassword')->name('home.editPassword');
    Route::patch('home/editPassword', 'HomeController@updatePassword')->name('home.updatePassword');
});

Route::get('/logActivity/getActivity/{id}', 'MeetingController@getActivity')->name('logActivity.getActivity');
Route::get('/logActivity/{id}', 'MeetingController@logActivity')->name('logActivity');
Route::get('/logActivity/delete/{id}', 'MeetingController@deleteActivity')->name('deleteActivity');

Route::get('/profile/getActivityUser/{id}', 'ProfileController@getActivity')->name('profile.getActivityUser');
Route::get('/profile/logActivity/{id}', 'ProfileController@logActivity')->name('profile.logActivity');



