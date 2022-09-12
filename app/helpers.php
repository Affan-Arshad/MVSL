<?php

use Illuminate\Support\Facades\Session;

if (!function_exists('flashMessage')) {
    function flashMessage($message, $type) {
        $oldMessages = Session::get('messages');
        if ($oldMessages == null) $oldMessages = [];

        Session::flash('messages', array_merge($oldMessages, [$message => $type]));
    }
}
