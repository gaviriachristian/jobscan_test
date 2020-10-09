<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'skills';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'skill_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'active'];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
    }
}
