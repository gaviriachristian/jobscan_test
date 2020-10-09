<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'company_id';

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
