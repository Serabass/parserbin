<?php

namespace Parserbin\Providers;

use AdminNavigation;
use KodiCMS\Assets\Facades\PackageManager;
use SleepingOwl\Admin\Contracts\Widgets\WidgetsRegistryInterface;
use SleepingOwl\Admin\Navigation\Page;
use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;

class AdminSectionsServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $sections = [
        \Parserbin\User::class            => 'Parserbin\Http\Sections\Users',
        \Parserbin\Models\Parser::class   => 'Parserbin\Http\Sections\Parser',
        \Parserbin\Models\Script::class   => 'Parserbin\Http\Sections\Script',
        \Parserbin\Models\Language::class => 'Parserbin\Http\Sections\Language',
    ];

    /**
     * Register sections.
     *
     * @return void
     */
    public function boot(\SleepingOwl\Admin\Admin $admin)
    {
        //

        parent::boot($admin);

        $this->registerNRoutes();
        $this->registerNavigation();
        $this->registerMediaPackages();
        $this->app->call([$this, 'registerViews']);
    }

    private function registerNavigation()
    {
        $pages = [
            [\Parserbin\Models\Parser::class, 300, 'Парсеры'],
            [\Parserbin\Models\Language::class, 300, 'Языки'],
            [\Parserbin\Models\Script::class, 300, 'Скрипты'],
            [\Parserbin\User::class, 300, 'Пользователи'],
        ];

        foreach ($pages as $page) {
            list($class, $priority, $title) = $page;
            $page = new Page($class);

            $page
                ->setPriority($priority)
                ->setTitle($title);

            AdminNavigation::addPage($page);
        }
    }

    private function registerNRoutes()
    {
        /**
         * @var \Illuminate\Routing\Router
         */
        $router = $this->app['router'];
        $router->group([
            'prefix'               => config('sleeping_owl.url_prefix'),
            'middleware'           => config('sleeping_owl.middleware'), ], function ($router) {
                $router->get('', ['as' => 'admin.dashboard', function () {
                    $content = 'Define your dashboard here.';

                    return AdminSection::view($content, 'Dashboard');
                }]);
            });
    }

    private function registerMediaPackages()
    {
        PackageManager::add('front.controllers')
            ->js(null, asset('js/controllers.js'));
    }

    /**
     * @param WidgetsRegistryInterface $widgetsRegistry
     */
    public function registerViews(WidgetsRegistryInterface $widgetsRegistry)
    {
        // foreach ($this->widgets as $widget) {
        //     $widgetsRegistry->registerWidget($widget);
        // }
    }
}
