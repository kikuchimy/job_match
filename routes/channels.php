<?php

use App\Models\Entry;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
Broadcast::channel('job-match.{entry}', function ($user, $entry_id) {
    $entry = Entry::find($entry_id);
    return $user->id === $entry->user_id
        || $user->id === $entry->jobOffer->company->user_id;
});
