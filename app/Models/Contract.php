<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'cmc_table';
	protected $connection = 'client_mysql';
	protected $appends = ['purchase_contract_link'];


    public function getPurchaseContractLinkAttribute()
    {
        return config('common.client_url').trim($this->Contractid).'.pdf';
    }

}
