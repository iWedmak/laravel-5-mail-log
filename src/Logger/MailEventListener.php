<?php namespace iWedmak\Mail;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class MailEventListener
{
	public function onRead($event)
	{
		try
		{
			$mailLog=MailLog::where('id', $event->id)->firstOrFail();
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
        if(isset($bcc) && !empty($bcc) && $bcc==\Config::get('maillog.bcc_skeep'))
        {
            
        }
        else
        {
            $hash=hash('md5',$body);
            try
            {
                $mailLog=MailLog::where('to', $to)->where('subject', $subject)->where('body', $hash)->firstOrFail();
				$mailLog->attempt+=1;
                if
                    (
                        isset($bcc) && !empty($bcc) 
                        && 
                        $bcc==\Config::get('maillog.bcc_delay') 
                        && 
                        strtotime($mailLog['sended_at'])<strtotime('- '.\Config::get('maillog.delay').' minutes')
                    )
                {
                    $mailLog->sended_at=date('Y-m-d H:i:s', time());
					$mailLog->save();
                }
                else
                {
                    $mailLog->save();
                    return false;
                }
            }
            catch(ModelNotFoundException $e)
            {
                $mailLog=new MailLog;
				$mailLog->to=$to;
				$mailLog->subject=$subject;
				$mailLog->body=$hash;
				$mailLog->sended_at=date('Y-m-d H:i:s', time());
				$mailLog->save();
				$body=$body.'<img src="'.\URL::route('MailRead', $mailLog['id']).'" height="1px" width="1px">';
				$message->setBody($body);
            }
		}
		$message->setBcc([]);
	}

	public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Mail\Events\MessageSending',
            'iWedmak\Mail\MailEventListener@onSend'
        );
        
        $events->listen(
            'iWedmak\Mail\MessageRead',
            'iWedmak\Mail\MailEventListener@onRead'
        );
    }
}
