<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Storage;
use Carbon\Carbon;

class NotificationsController extends Controller
{
    /**
     * Loads the list of notifications view
     *
     * @return View
     */
    public function index() {
        return view('admin.notifs')
            ->with('notifications', $this->getNotifs()['notifications'] );
    }

    /**
     * Update the latest notification seen by the user
     *
     * @param Int ID of the notification
     */
    public function setRead($id) {
        Auth::user()->notif_id = intval($id);
        Auth::user()->save();
    }

    /**
     * Get the notifications from the cache or from the API
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
