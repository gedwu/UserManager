<?php

namespace UserManager;

use Illuminate\Database\Eloquent\Model;

/**
 * UserManager\UserManager
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\UserManager\UserManager newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\UserManager\UserManager newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\UserManager\UserManager query()
 * @mixin \Eloquent
 */
class UserManager extends Model
{
    protected $table = 'user_managers';
    protected $fillable = ['name', 'email', 'phone', 'website'];
}
