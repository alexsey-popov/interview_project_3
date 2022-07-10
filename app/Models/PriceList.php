<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class PriceList extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'provider', 'validity_period', 'currency'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['updated_at', 'deleted_at'];

    /**
     * Dates fields
     * @var string[]
     */
    protected $dates = ['validity_period', 'created_at'];

    /**
     * Get items for this price list
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(PriceListItem::class);//->bySystemTime($date);
    }

    /**
     * Filter actual version data at time
     * @param Request $request
     * @return mixed
     */
    public static function getAtTime(Request $request)
    {
        $date = self::getNeedDate($request);

        // Получаем актуальные данные на выбранное время, подробнее в AppServiceProvider
        $query = self::bySystemTime($date);

        // Отсекаем просроченные прайслисты
        if(!$request->get('delay')) {
            $query = $query->where('validity_period', '>=', date('Y-m-d', strtotime($date)));
        }

        return $query;
    }

    /**
     * Get request actuality date or now
     * @param Request $request
     * @return string
     */
    public static function getNeedDate(Request $request)
    {
        return date('Y-m-d H:i:s', strtotime($request->get('actuality_date', now())));
    }

    /**
     * Check validity_period to date
     * @param $date
     * @return bool
     */
    public function isActual($date)
    {
        return strtotime($this->validity_period->format('Y-m-d 23:59:59')) < strtotime($date);
    }
}
