<?php

namespace Modules\Users\Http\Resources;

use App\Traits\UploadFiles;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    use UploadFiles;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'email' => $this->email,
            'token' => $this->token,
            'profile_image' => $this->profile_image ? $this->getFileUrl($this->profile_image) : '',
            'allow_notify' => $this->allow_notify,
        ];
    }
}
