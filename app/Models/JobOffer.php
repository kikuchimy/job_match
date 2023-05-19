<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class JobOffer extends Model
{
    use HasFactory;

    // 並び替え
    const SORT_NEW_ARRIVALS = 1;
    const SORT_VIEW_RANK = 2;
    const SORT_LIST = [
        self::SORT_NEW_ARRIVALS => '新着',
        self::SORT_VIEW_RANK => '人気',
    ];

    // ステータス
    const STATUS_CLOSE = 0;
    const STATUS_OPEN = 1;
    const STATUS_LIST = [
        self::STATUS_CLOSE => '未公開',
        self::STATUS_OPEN => '公開',
    ];

    protected $fillable = [
        'title',
        'occupation_id',
        'due_date',
        'description',
        'is_published',
    ];

    public function scopePublished(Builder $query)
    {
        $query->where('is_published', true)
            ->where('due_date', '>=', now());
        return $query;
    }

    public function scopeSearch(Builder $query, $params)
    {
        if (!empty($params['occupation_id'])) {
            $query->where('occupation_id', $params['occupation_id']);
        }

        return $query;
    }

    public function scopeOrder(Builder $query, $params)
    {
        if ((empty($params['sort'])) ||
            (! empty($params['sort']) && $params['sort'] == self::SORT_NEW_ARRIVALS)
        ) {
            $query->latest();
        } elseif (! empty($params['sort']) && $params['sort'] == self::SORT_VIEW_RANK) {
            $query->withCount('jobOfferViews')
                ->orderBy('job_offer_views_count', 'desc');
        }

        return $query;
    }

    public function scopeMyJobOffer(Builder $query, $params)
    {
        if (Auth::user()->can('company')) {
            $query->latest()
                ->with(['entries', 'occupation'])
                ->where('company_id', Auth::user()->company->id)
                ->where('is_published', $params['is_published'] ?? self::STATUS_OPEN);
        } else {
            $query->latest()
                ->with(['entries', 'occupation'])
                ->whereHas('entries', function ($query) use ($params) {
                    $query->where('user_id', Auth::user()->id);
                });
        }

        return $query;
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function occupation()
    {
        return $this->belongsTo(Occupation::class);
    }

    public function jobOfferViews()
    {
        return $this->hasMany(JobOfferView::class);
    }

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'messageable');
    }
}
