<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Valuestore\Valuestore;

class SentEmailArchives extends Model
{
    protected $table = "sent_email_archives";
}
