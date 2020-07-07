<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class QrcodeCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'company_name' => $this->company_name,
            'amount' => $this->amount,
            'product_name' => $this->product_name,
            'link' => [
                'qrcode_link' => route('qrcodes.show', $this->id),
            ]
        ];
    }
}
