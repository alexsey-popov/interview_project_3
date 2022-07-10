<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceListItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'price_list_id', 'name', 'article_number', 'price'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['updated_at', 'deleted_at'];

    protected $dates = ['created_at'];

    /**
     * Get the price list that owns the item.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function priceList()
    {
        return $this->belongsTo(PriceList::class);
    }
}
