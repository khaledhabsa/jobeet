<?php

namespace Modules\Users\Transformers;

use App\Traits\UploadFiles;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProfileResource extends JsonResource
{
    use UploadFiles;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'profile_image' => $this->profile_image ? $this->getFileUrl($this->profile_image) : '',
        ];
    }
}
