<?php namespace iWedmak\Mail;

use Illuminate\Database\Eloquent\Model;

class MailLog extends Model{

	protected $softDelete = true;
    protected $table;
    protected $guarded=array();

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = \Config::get('maillog.log_table');
    }
}