<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use App\Services\ToDoListService;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    public function __construct() {
        $this->toDoListService = new ToDoListService();
    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        /**
         * Validate two fields value are same
         * 
         * @parameters[0], password value
         * @return bool
         */
        Validator::extend('confirmationPassword', function ($attribute, $value, $parameters, $validator) {            
            return $value === $parameters[0];
        });

        $this->registerMenu($events);
    }

    /**
     * Register menu.
     *
     * @return void
     */
    private function registerMenu(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $res = $this->toDoListService->getIncompleteToDoListCount(Session::get('user_id'));
            $incompleteCount = json_decode($res->getBody()->getContents());

            $event->menu->add([
                'text'        => 'To do list',
                'url'         => '',
                'icon'        => 'file-text-o',
                'label'       => $incompleteCount,
                'label_color' => 'success',
            ]);
            
            // Account menu
            $event->menu->add('ACCOUNT SETTINGS');
            $event->menu->add([
                'text' => 'Profile',
                'url'  => '/account/profile',
                'icon' => 'user',
            ]);
            $event->menu->add([
                'text' => 'Change Password',
                'url'  => '/account/changepassword',
                'icon' => 'lock',
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
