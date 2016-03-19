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
    | Where to store emails, change before migration
    |
    */
    'log_table' => 'maillog',
    /*
    |--------------------------------------------------------------------------
    | MailLog delay
    |--------------------------------------------------------------------------
    |
    | Delay period in minutes for email's duplicates
    |
    */
    'delay' => 30,
    /*
    |--------------------------------------------------------------------------
    | MailLog delay email
    |--------------------------------------------------------------------------
    |
    | Dilay email, so email duplicates will come in delay
    |
    */
    'bcc_delay' => 'delay@me.com',
    /*
    |--------------------------------------------------------------------------
    | Maillog Skeep Address
    |--------------------------------------------------------------------------
    |
    | Addres in bcc to skeep logging in db
    |
    */
    'bcc_skeep' => 'skeep@me.com',
];