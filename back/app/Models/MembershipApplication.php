<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipApplication extends Model
{
    protected $fillable = ['name', 'organization', 'phone', 'email', 'plan_slug', 'status', 'admin_note'];

    public static array $statuses = ['new', 'accepted', 'replied', 'resolved'];
}
