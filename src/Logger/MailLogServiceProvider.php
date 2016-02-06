<?php namespace iWedmak\Mail;

use Illuminate\Support\ServiceProvider;
class MailLogServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config files
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('maillog.php')
        ], 'config');
        // Register commands
        $this->commands('command.maillog.migration');
        
        // Register route
        if (! $this->app->routesAreCached()) {
            \Route::get('/mail/{id}.jpg', 
                function ($id) 
                {
                    \Event::fire(new MessageRead($id));
                }
            )->name('MailRead')->pattern('id', '[0-9]+');
        }
        
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands();
    }
    /**
     * Register the artisan commands.
     *
     * @return void
     */
    private function registerCommands()
    {
        $this->app->singleton('command.maillog.migration', function ($app) {
            return new MigrationCommand();
        });
    }
    /**
     * Get the services provided.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.maillog.migration'
        ];
    }
}