<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OSFixing extends Model
{
    protected $table = 'fx_table';
    protected $connection = 'client_mysql';
    protected $appends = ['purchase_contract_link'];


    public function getPurchaseContractLinkAttribute()
    {
        return config('common.client_url').trim($this->contract).'.pdf';
    }
}