<?php

namespace Parserbin;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Parserbin\Models\Parser;

/**
 * Parserbin\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property bool $has_parsers
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Parserbin\Models\Parser[] $parsers
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Parserbin\User onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Parserbin\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Parserbin\User withoutTrashed()
 * @mixin Eloquent
 * @property int $is_admin
 * @method static \Illuminate\Database\Eloquent\Builder|\Parserbin\User whereIsAdmin($value)
 */
class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    public static function me()
    {
        return User::with('parsers')
            ->whereId(auth()->id())
            ->first();
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email',
        'is_admin',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function parsers()
    {
        return $this->hasMany(Parser::class, 'user_id');
    }

    public function getHasParsersAttribute()
    {
        return $this->parsers->count() > 0;
    }

    public function url()
    {
        return route('user.index', [
            'username' => $this->name
        ]);
    }
}
