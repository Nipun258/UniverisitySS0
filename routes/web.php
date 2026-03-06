<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OAuthClientController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Auth\SsoAdminLoginController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Setup\CategoryController;
use App\Http\Controllers\Setup\CategoryTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('login'));


Route::group(['middleware' => 'prevent-back-history'], function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->middleware(['auth', 'verified', 'sso.dashboard', 'permission:dashbord.view'])->name('dashboard');
    Route::get('/dashboard/live-traffic', [AdminController::class, 'liveTraffic'])->middleware(['auth', 'sso.dashboard'])->name('dashboard.live-traffic');

    Route::middleware('auth', 'permission:dashbord.view')->prefix('profile')->group(function () {

        Route::get('/view', [AdminController::class, 'ProfileView'])->name('profile.view');
    }); //user profile controller route list

    Route::middleware('auth')->prefix('user')->group(function () {

        Route::get('/view', [UserController::class, 'UserView'])->name('user.view')->middleware('permission:user.view');

        Route::group(['middleware' => ['permission:user.create']], function () {
            Route::get('/add/view', [UserController::class, 'UserAddView'])->name('user.add.view');
            Route::post('/store', [UserController::class, 'UserStore'])->name('user.store');
        });

        Route::group(['middleware' => ['permission:user.updation']], function () {
            Route::get('/edit/{id}', [UserController::class, 'UserEdit'])->name('user.edit');
            Route::post('/update/{id}', [UserController::class, 'UserUpdate'])->name('user.update');
        });

        Route::get('/delete/{id}', [UserController::class, 'UserDelete'])->name('user.delete')->middleware('permission:user.delete');

        Route::get('/inactive/{id}', [UserController::class, 'UserInactive'])->name('user.inactive')->middleware('permission:user.inactivate');

        Route::get('/active/{id}', [UserController::class, 'UserActive'])->name('user.active')->middleware('permission:user.activate');

        Route::get('/show/{id}', [UserController::class, 'UserShow'])->name('user.show')->middleware('permission:user.show');

        Route::post('/users/{user}/roles', [UserController::class, 'assignRole'])->name('users.roles')->middleware('permission:user.roles.assign');
        Route::get('/users/{user}/roles/{role}', [UserController::class, 'removeRole'])->name('users.roles.remove')->middleware('permission:user.roles.remove');
        Route::post('/users/{user}/permissions', [UserController::class, 'givePermission'])->name('users.permissions')->middleware('permission:user.permissions.assign');
        Route::get('/users/{user}/permissions/{permission}', [UserController::class, 'revokePermission'])->name('users.permissions.revoke')->middleware('permission:user.permissions.revoke');

        // SSO availability check – verify token validity and user status
        Route::get('/availability', [UserController::class, 'userAvailability'])->name('user.availability');
    }); //user manage controller route list


    Route::middleware('auth')->prefix('role')->group(function () {

        Route::get('/index', [RoleController::class, 'roleIndex'])->name('role.index')->middleware('permission:role.index');

        Route::group(['middleware' => ['permission:role.create']], function () {
           Route::get('/add', [RoleController::class, 'roleAdd'])->name('role.add');
           Route::post('/store', [RoleController::class, 'roleStore'])->name('role.store');
        });

        Route::group(['middleware' => ['permission:role.updation']], function () {
           Route::get('/edit/{id}', [RoleController::class, 'roleEdit'])->name('role.edit');
           Route::post('/update/{id}', [RoleController::class, 'roleUpdate'])->name('role.update');
        });

        Route::get('/delete/{id}', [RoleController::class, 'roleDelete'])->name('role.delete')->middleware('permission:role.delete');
        Route::get('/permissions/list/{id}', [RoleController::class, 'rolePermissionList'])->name('role.permission.list')->middleware('permission:role.permission.list');
        Route::post('permission/role/update/{role}', [RoleController::class, 'permissionRoleUpdate'])->name('role.permission.update')->middleware('permission:role.permission.update');
        Route::get('/roles/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('roles.permissions.revoke')->middleware('permission:role.permissions.revoke');
        Route::post('/role/{role}/sync-permissions', [RoleController::class, 'syncPermissions'])->name('role.syncPermissions')->middleware('permission:role.permissions.sync');
    }); //system role management route list

    Route::middleware('auth')->prefix('permission')->group(function () {

        Route::get('/index', [PermissionController::class, 'permissionIndex'])->name('permission.index')->middleware('permission:permission.index');

        Route::group(['middleware' => ['permission:permission.create']], function () {
           Route::get('/add', [PermissionController::class, 'permissionAdd'])->name('permission.add');
           Route::post('/store', [PermissionController::class, 'permissionStore'])->name('permission.store');
        });

        Route::group(['middleware' => ['permission:permission.updation']], function () {
           Route::get('/edit/{id}', [PermissionController::class, 'permissionEdit'])->name('permission.edit');
           Route::post('/update/{id}', [PermissionController::class, 'permissionUpdate'])->name('permission.update');
        });

        Route::get('/delete/{id}', [PermissionController::class, 'permissionDelete'])->name('permission.delete')->middleware('permission:permission.delete');
        Route::post('/permissions/{permission}/roles', [PermissionController::class, 'assignRole'])->name('permissions.roles')->middleware('permission:permission.roles.assign');
        Route::get('/permissions/{permission}/roles/{role}', [PermissionController::class, 'removeRole'])->name('permissions.roles.remove')->middleware('permission:permission.roles.remove');
    }); //system permission route list


    Route::middleware('auth')->prefix('setup')->group(function () {

        Route::get('/catagory/type/view', [CategoryTypeController::class, 'CategoryTypeIndex'])->name('category.type.index')->middleware('permission:category.type.list');

        Route::group(['middleware' => ['permission:category.type.create']], function () {
           Route::get('/catagory/type/add', [CategoryTypeController::class, 'CategoryTypeAdd'])->name('category.type.add');
           Route::post('/category/type/store', [CategoryTypeController::class, 'CategoryTypeStore'])->name('category.type.store');
        });

        Route::group(['middleware' => ['permission:category.type.updation']], function () {
           Route::get('/category/type/edit/{id}', [CategoryTypeController::class, 'CategoryTypeEdit'])->name('category.type.edit');
           Route::post('/category/type/update/{id}', [CategoryTypeController::class, 'CategoryTypeUpdate'])->name('category.type.update');
        });

        Route::get('/category/type/delete/{id}', [CategoryTypeController::class, 'CategoryTypeDelete'])->name('category.type.delete')->middleware('permission:category.type.delete');

        Route::get('/category/list/{id}', [CategoryTypeController::class, 'CategoryList'])->name('category.list')->middleware('permission:category.list.check');

        /***************************************************************************************************** */

        Route::get('/category/view', [CategoryController::class, 'CategoryIndex'])->name('category.index')->middleware('permission:category.list');

        Route::group(['middleware' => ['permission:category.create']], function () {
           Route::get('/category/add', [CategoryController::class, 'CategoryAdd'])->name('category.add');
           Route::post('/category/store', [CategoryController::class, 'CategoryStore'])->name('category.store');
        });

        Route::group(['middleware' => ['permission:category.updation']], function () {
          Route::get('/category/edit/{id}', [CategoryController::class, 'CategoryEdit'])->name('category.edit');
          Route::post('/category/update/{id}', [CategoryController::class, 'CategoryUpdate'])->name('category.update');
        });

        Route::get('/category/delete/{id}', [CategoryController::class, 'CategoryDelete'])->name('category.delete')->middleware('permission:category.delete');
    });

    Route::middleware('auth')->prefix('setting')->group(function () {

        Route::get('/view', [SiteSettingController::class, 'index'])->name('site.setting.index')->middleware('permission:site.setting.index');
        Route::post('/update', [SiteSettingController::class, 'update'])->name('site.settings.update')->middleware('permission:site.settings.update');
        Route::get('/restore/default', [SiteSettingController::class, 'restoreDefault'])->name('site.settings.restore.default')->middleware('permission:site.settings.restore.default');
    }); //user profile controller route list

    // OAuth Client Management (SSO Server)
    Route::middleware(['auth'])->prefix('oauth-clients')->group(function () {
        Route::get('/', [OAuthClientController::class, 'index'])->name('oauth.client.index')->middleware('permission:oauth.client.index');
        Route::get('/create', [OAuthClientController::class, 'create'])->name('oauth.client.create')->middleware('permission:oauth.client.create');
        Route::post('/store', [OAuthClientController::class, 'store'])->name('oauth.client.store')->middleware('permission:oauth.client.create');
        Route::get('/edit/{id}', [OAuthClientController::class, 'edit'])->name('oauth.client.edit')->middleware('permission:oauth.client.update');
        Route::put('/update/{id}', [OAuthClientController::class, 'update'])->name('oauth.client.update')->middleware('permission:oauth.client.update');
        Route::get('/destroy/{id}', [OAuthClientController::class, 'destroy'])->name('oauth.client.destroy')->middleware('permission:oauth.client.delete');
        Route::get('/regenerate/{id}', [OAuthClientController::class, 'regenerateSecret'])->name('oauth.client.regenerate')->middleware('permission:oauth.client.update');
    }); // OAuth Client Management

}); //prevent back history

// ── SSO Admin Portal — Separate login (NOT the same as regular /login) ──
Route::prefix('sso-admin')->name('sso.admin.')->group(function () {
    // Guest-only routes
    Route::middleware('guest')->group(function () {
        Route::get('/login',  [SsoAdminLoginController::class, 'create'])->name('login');
        Route::post('/login', [SsoAdminLoginController::class, 'store'])->name('login.post');
    });
    // Logout (auth required)
    Route::post('/logout', [SsoAdminLoginController::class, 'destroy'])
         ->name('logout')
         ->middleware('auth');
});

require __DIR__ . '/auth.php';
