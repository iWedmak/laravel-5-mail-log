<?php namespace iWedmak\Mail\Events;

class MessageRead
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
    
}
