<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

use Carbon\Carbon;
use Storage;
use Auth;

class NotificationsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('admin.partials.topbar', function (View $view) {
            $notifs = $this->getNotifs();

            $notifs['lastId'] = max( array_column($notifs['notifications'], 'id') );
            $notifs['unread'] = $notifs['lastId'] - Auth::user()->notif_id;

            // Reduce the number of notifications
            $array = array();
            for($i = $notifs['lastId']; ($i > 0 && $i > $notifs['lastId'] - 3); $i--) {

                $key = array_search($i, array_column($notifs['notifications'], 'id') );
                $array[] = $notifs['notifications'][$key];
            }
            $notifs['notifications'] = $array;

            $view->with('notifs', $notifs);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the notifications
     */
    public function getNotifs() {

        // Notifications stored
        if( Storage::exists('notifications.ser') ) {
            $notifs = unserialize( Storage::get('notifications.ser') );

            // If the query is too old, remove the notifs
            if( Carbon::now()->timestamp - $notifs['query_date'] > 60 )
                $notifs = null;
        }

        // Get the information for the API
        if( !isset($notifs) ) {
            $notifs = [
                'query_date' => Carbon::now()->timestamp,
                'notifications' => getJSON( env('APP_URL_SERVER') . '/api/notifications' )
            ];

            // Store the new query
            Storage::put('notifications.ser', serialize($notifs));
        }

        return $notifs;
    }
}
