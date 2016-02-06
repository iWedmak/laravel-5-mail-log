<?php namespace iWedmak\Mail;

class MailLoger
{
	
    private $model;
    
    public function __construct()
    {
        $this->model=Config::get('maillog.model');
    }
    
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

	public function onSend($message)
	{
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
                /*
				$array=array(
							'message'=>'Attempt to send email second time, prevented',
							'to'=>$to,
							'subject'=>$subject,
							//'body'=>$body,
						);
				$mail=\Mail::send(array('html'=>'emails.data'), array('data'=>$array), function($message)
				{
					$message
					->to('iwedmak@gmail.com')
					->bcc('skeep@lavkalavka.com')
					->subject('Попытка отправить емейл повторно')
					;
				});
                //*/
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
        
		//pre($subject);
        //\App::abort(404);
        //unset($message);
        //$message=false;
        //return unset($message);
	}

	public function subscribe($events)
    {
        $events->listen(
            'App\Events\MessageSending',
            'iWedmak\MailLoger\MailLoger@onSend'
        );
    }
}