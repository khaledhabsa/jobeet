<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use Modules\Basic\Entities\Setting;

trait Settings{
    public function getSettings(){
        return Cache::rememberForever('settings', function (){
            $data   = Setting::all();
            $settings =[];
            foreach ($data as $item){
                $settings[$item->key] = $item->value;
            }
            return $settings;
        });
    }

    public function getSetting($key){
        return $this->getSettings()[$key];
    }

    public function cleanHtml($t){
        $allowed_tags= "<p><span><br><ul><li><h1><h2><h3><h4><h5><h6><b><strong><i>";
        $t = strip_tags($t, $allowed_tags);
        $t =preg_replace("/<([a-z][a-z0-9]*)(?:[^>]*(\ssrc=['\"][^'\"]*['\"]))?[^>]*?(\/?)>/i",'<$1$2$3>', $t);
        return str_replace('<p>&nbsp;</p>', '', $t);
    }
}
