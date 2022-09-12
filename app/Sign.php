<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class Sign extends Model {
    use \Spatie\Tags\HasTags;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted() {
        static::deleted(function ($sign) {
            if (Storage::exists($sign->video)) {
                Storage::delete($sign->video);
                flashMessage('Related file deleted', 'success');
            }
        });
    }
}
