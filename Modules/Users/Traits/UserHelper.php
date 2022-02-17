<?php

namespace Modules\Users\Traits;

trait UserHelper {
    public function userLocale(){
        $user = request()->user('api');
        $locale = 'ar';
        if (isset($user)){
            $locale = $user->locale;
        }

        return $locale;
    }
}
