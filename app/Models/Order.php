<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'user_id', 'status', 'detail', 'price'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @param Builder $query
     * @return void
     */
    public function scopeAuthUserOrders(Builder $query): void
    {
        $this->scopeSpecificUsersOrders($query, [Auth::user()->id]);
    }

    /**
     * @param Builder $query
     * @param array $userIds
     * @return void
     */
    public function scopeSpecificUsersOrders(Builder $query, array $userIds): void
    {
        $query->whereIn('user_id', $userIds);
    }

    /**
     * @param array $orderVariationsParams
     * @return string
     */
    public static function generateOrderDetailText(array $orderVariationsParams): string
    {
        $result = '';
        foreach ($orderVariationsParams as $orderVariationsParam) {
            $variation = Variation::find($orderVariationsParam['id']);
            $option = Option::find($orderVariationsParam['option_id']);

            $result .= $variation->title . config('character.plain_text.colon') .
                $option->title . config('character.plain_text.comma');
        }
        return $result;
    }
}
