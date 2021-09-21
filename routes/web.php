<?php

use Illuminate\Support\Facades\Route;

Route::get('/now', function(){ return \Carbon\Carbon::now()->minute; });

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('/', function () { return redirect(route('monitorings.index')); });
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
    
    // Route::get('/about', function() {
    // echo "About Us";
    // });

    

    Route::get('/areaManagement', function () { return view('areaManagement'); });
    Route::get('/StationManage', function () { return view('StationManage'); });
    Route::get('/tempManage', function () { return view('tempManage'); });
    Route::get('/Profile', function () { return view('Profile'); });
    Route::get('/Frostbite', function () { return view('Frostbite'); });
    Route::get('/DiseaseManage', function () { return view('DiseaseManage'); });
    Route::get('/UserManage', function () { return view('UserManage'); });
    Route::get('/logout', function(){
        Auth::logout();
        return Redirect::to('/login');
    });

    
    Route::prefix('admin')->group(function () {
        Route::get('/map', function () { return view('map'); })->name('map');

        Route::resource('/stations', 'StationController');
        Route::get('/charts/{station}/{param}', 'StationController@chart')->name('charts.detailChart');
        Route::get('/getChartData/{station}', 'StationController@getChartData')->name('charts.getChartData');
        Route::get('/getChartReport/{station}/{date}','StationController@getChartReport')->name('charts.getChartReport');
        Route::resource('areas', 'AreaController');
        Route::post('cities', 'AreaController@storeCity')->name('cities.store');
        Route::put('cities/{city}', 'AreaController@updateCity')->name('cities.update');
        Route::delete('cities/{city}', 'AreaController@destroyCity')->name('cities.destroy');

        Route::resource('/illnesses', 'IllnessController', ['except' => ['create', 'edit', 'show']]);
        Route::resource('/plants', 'PlantController', ['except' => ['create', 'edit', 'show']]);
        Route::resource('/pests', 'PestController', ['except' => ['create', 'edit', 'show']]);
        Route::resource('/stations', 'StationController', ['except' => ['create', 'edit', 'show']]);
        Route::resource('/degreeDayPlants', 'degreeDayPlantController', ['except' => ['create', 'edit', 'show']]);
        Route::resource('/degreeDayPests', 'degreeDayPestController', ['except' => ['create', 'edit', 'show']]);

        Route::get('chart', 'ChartController@index');

        Route::resource('monitorings', 'MonitoringController');


        Route::get('/reports', 'ReportController@index')->name('reports.index');
        Route::get('/dailyReport', 'ReportController@dailyReport')->name('reports.dailyReport');
        Route::get('/getDailyReport/{device}/{date}', 'ReportController@getDailyReport')->name('reports.getDailyReport');

        Route::get('/getChartReport/{device}/{date}','StationController@getChartReport')->name('reports.getChartReport');

        Route::get('/periodicReport', 'ReportController@periodicReport')->name('reports.periodicReport');
        Route::get('/getperiodicReport/{device}/{dateFrom}/{dateTo}','ReportController@getperiodicReport')->name('reports.getperiodicReport');
        Route::get('/hourlyReport', 'ReportController@hourlyReport')->name('reports.hourlyReport');
        Route::get('/getHourlyReport/{device}/{from}/{to}', 'ReportController@getHourlyReport')->name('reports.getHourlyReport');

        Route::get('/yearReport', 'ReportController@yearReport')->name('reports.yearReport');
        Route::get('/DoDreportPlant', 'ReportController@DoDreportPlant')->name('reports.DoDreportPlant');
        Route::get('/DoDreportPest', 'ReportController@DoDreportPest')->name('reports.DoDreportPest');
        Route::get('/LengthGrowingSeason', 'ReportController@LengthGrowingSeason')->name('reports.LengthGrowingSeason');

        Route::resource('dangers', 'DangerController');

        Route::get('/CoolWavesReport', 'DangerController@CoolWavesReport')->name('dangers.CoolWavesReport');
        Route::get('/RainfallReport', 'DangerController@RainfallReport')->name('dangers.RainfallReport');
        Route::get('/glacialReport', 'DangerController@glacialReport')->name('dangers.glacialReport');
        Route::get('/HeatWaveReport', 'DangerController@HeatWaveReport')->name('dangers.HeatWaveReport');
        Route::get('/NeedCooling', 'DangerController@NeedCooling')->name('dangers.NeedCooling');
        Route::get('/WetTempThreshold', 'DangerController@WetTempThreshold')->name('dangers.WetTempThreshold');


        Route::group(['middleware' => 'role:admin'], function () {
            Route::resource('users', 'UserController');
            Route::get('users/{user}/resetPassword', 'UserController@resetPassword')->name('users.resetPassword');
            Route::get('users/{user}/changePassword','UserController@changePassword')->name('users.changePassword');
            Route::post('users/updatePassword', 'UserController@updatePassword')->name('users.updatePassword');

            Route::get('permissions', 'PermissionController@index')->name('permissions.index');

            Route::post('roles', 'PermissionController@storeRole')->name('roles.store');
            Route::put('roles/{role}', 'PermissionController@updateRole')->name('roles.update');
            Route::delete('roles/{role}', 'PermissionController@destroyRole')->name('roles.destroy');

            Route::post('permissions', 'PermissionController@storePermission')->name('permissions.store');
            Route::put('permissions/{permission}', 'PermissionController@updatePermission')->name('permissions.update');
            Route::delete('permissions/{permission}', 'PermissionController@destroyPermission')->name('permissions.destroy');

            // updateRolePermissions
            Route::post('rolePermissions', 'PermissionController@updateRolePermissions')->name('roles.updateRolePermissions');
            Route::post('userRoles', 'PermissionController@updateUserRoles')->name('roles.updateUserRoles');

            Route::post('stations/assignUser', 'UserController@assignUserStation')->name('stations.assignUser');
            Route::post('stations/revokeUser', 'UserController@revokeUserStation')->name('stations.revokeUser');
        });
    });
});

// Route::get('/showData', function () { return view('showData'); });

Route::prefix('api')->group(function () {
    Route::post('/storeDeviceSensorData', 'ApiController@storeDeviceSensorData')->name('storeDeviceSensorData');
    Route::get('/getLatestDeviceSensorData/{device}', 'ApiController@getLatestDeviceSensorData')->name('getLatestDeviceSensorData');
});

Route::get('/myRout/{name?}',function($name=null){

    return $name;

});
