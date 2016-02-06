<?php namespace iWedmak\Mail;

class MailEventListener
{
	public function onRead($id)
	{
		try
		{
			$mailLog=MailLog::where('id', $id)->firstOrFail();
			$mailLog->read=true;
			$mailLog->save();
		}
		catch(Exception $e)
		{
			//pre($e->getMessage());
		}
	}

	public function onSend($event)
	{
		$message=$event->message;
		$body=$message->getBody();
		$subject=$message->getSubject();
        $to=key($message->getTo());
        @$bcc=key($message->getBcc());
        if(isset($bcc) && !empty($bcc) && ( $bcc==\Config::get('maillog.bcc') ))
        {
            
        }
        else
        {
			$mailLog=MailLog::where('to', $to)->where('subject', $subject)->where('body', strip_tags($body))->first();
			if(isset($mailLog['id']) && !empty($mailLog['id']))
			{
				$message->setTo(array());
                $mailLog->increment('attempt');
			}
			else
			{
				$mailLog=new MailLog;
				$mailLog->to=$to;
				$mailLog->subject=$subject;
				$mailLog->body=strip_tags($body);
				$mailLog->save();
				$body=$body.'<img src="'.\URL::route('MailRead', $mailLog['id']).'" height="1px" width="1px">';
				$message->setBody($body);
			}
		}
		$message->setBcc(array());
	}

	public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Mail\Events\MessageSending',
            'iWedmak\Mail\MailEventListener@onSend'
        );
    }
}