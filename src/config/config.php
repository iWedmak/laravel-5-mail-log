<?php
/**
 * This file is part of iWedmak\Mail-Log,
 * mailloger for Laravel.
 *
 * @license MIT
 * @package iWedmak\Mail-Log
 */
return [
    /*
    |--------------------------------------------------------------------------
    | MailLog Table
    |--------------------------------------------------------------------------
    |
    | Where to store emails
    |
    */
    'log_table' => 'maillog',
    /*
    |--------------------------------------------------------------------------
    | MailLog delay
    |--------------------------------------------------------------------------
    |
    | Dilay period in minutes for email's duplicates
    |
    */
    'delay' => 30,
    /*
    |--------------------------------------------------------------------------
    | Maillog Skeep Address
    |--------------------------------------------------------------------------
    |
    | Addres in bcc to skeep logging in db
    |
    */
    'bcc' => 'skeep@me.com',
];