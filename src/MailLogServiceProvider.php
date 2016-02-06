<?php namespace iWedmak\MailLoger;

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
            __DIR__.'/../config/config.php' => config_path('maillog.php'),
        ]);
        // Register commands
        $this->commands('command.maillog.migration');
        
        // Register blade directives
        $this->bladeDirectives();
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerEntrust();
        $this->registerCommands();
        $this->mergeConfig();
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
    private function mergeConfig()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'maillog'
        );
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