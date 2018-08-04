<?php

/*
 * В классе EMailer необходимо заменить private $_myMailer на protected $_myMailer
 */

require_once(__DIR__.DIRECTORY_SEPARATOR.'EMailer.php');

class MyEMailer extends EMailer
{
    public function __call($method, $params)
    {
        parent:: __call($method, $params);

        if (strtolower($method) == 'send')
            $this->reset();
    }

	public function reset()
	{
        $this->ClearAddresses();
        $this->ClearCCs();
        $this->ClearBCCs();
        $this->ClearReplyTos();
        $this->ClearAllRecipients();
        $this->ClearAttachments();
        $this->ClearCustomHeaders();
	}
}