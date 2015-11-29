<?php

namespace Lollypop\Traits;

use GuzzleHttp\Client;

/**
 * Trait Class Mailcatcher
 *
 * With this trait you can interact with
 * the rest api Mailcatcher  (https://github.com/sj26/mailcatcher) provides
 *
 * ---- Dependecies ------
 * "guzzlehttp/guzzle": "~6.0",
 * -----------------------
 *
 * @author Drakakis George
 * inspired by a mailcatcher codeception module
 *
 */
trait Mailcatcher
{

    /**
     * @var Client
     */
    protected $mailcatcher;


    public function setUp()
    {
        parent::setUp();
        $this->initializeMailCatcher();
    }


    public function initializeMailCatcher()
    {
        $url = '127.0.0.1:1080';
        $this->mailcatcher = new Client(['base_uri' => $url]);
        $this->resetEmails();
    }


    /**
     * Reset emails
     *
     * Clear all emails from mailcatcher. You probably want to do this before
     * you do the thing that will send emails
     *
     **/
    public function resetEmails()
    {
        $this->mailcatcher->request('DELETE', '/messages');
    }


    /**
     * See In Last Email
     *
     * Look for a string in the most recent email
     *
     **/
    public function seeInLastEmail($expected)
    {
        $email = $this->lastMessage();
        $this->seeInEmail($email, $expected);
    }

    /**
     * See In nth Email
     *
     * Look for a string in Nth($num) email
     *
     * @return void
     **/
    public function seeInEmailNth($num, $expected)
    {
        $email = $this->nthMessage($num);
        $this->seeInEmail($email, $expected);
    }

    /**
     * See In Nth Email subject
     *
     * Look for a string in Nth($num) email subject
     *
     * @return void
     **/
    public function seeInNthEmailSubject($num, $expected)
    {
        $email = $this->nthMessage($num);
        $this->seeInEmailSubject($email, $expected);
    }

    /**
     * Don't See In Nth Email subject
     *
     * Look for the absence of a string in Nth($num) email subject
     *
     * @return void
     **/
    public function dontSeeInNthEmailSubject($num, $expected)
    {
        $email = $this->nthMessage($num);
        $this->dontSeeInEmailSubject($email, $expected);
    }

    /**
     * Don't See In Nth Email
     *
     * Look for the absence of a string in Nth($num) email
     *
     * @return void
     **/
    public function dontSeeInNthEmail($num, $unexpected)
    {
        $email = $this->nthMessage($num);
        $this->dontSeeInEmail($email, $unexpected);
    }

    /**
     * See In Nth Email To
     *
     * Look for a string in Nth($num) email sent to $address
     *
     * @return void
     **/
    public function seeInNthEmailTo($num, $address, $expected)
    {
        $email = $this->nthMessageFrom($num, $address);
        $this->seeInEmail($email, $expected);
    }

    /**
     * Don't See In Nth Email To
     *
     * Look for the absence of a string in Nth($num) email sent to $address
     *
     * @return void
     **/
    public function dontSeeInNthEmailTo($num, $address, $unexpected)
    {
        $email = $this->nthMessageFrom($num, $address);
        $this->dontSeeInEmail($email, $unexpected);
    }

    /**
     * See In Nth Email Subject To
     *
     * Look for a string in Nth($num) email subject sent to $address
     *
     * @return void
     **/
    public function seeInNthEmailSubjectTo($num, $address, $expected)
    {
        $email = $this->nthMessageFrom($num, $address);
        $this->seeInEmailSubject($email, $expected);
    }

    /**
     * Don't See In Nth Email Subject To
     *
     * Look for the absence of a string in Nth($num) email subject sent to $address
     *
     * @return void
     **/
    public function dontSeeInNthEmailSubjectTo($num, $address, $unexpected)
    {
        $email = $this->nthMessageFrom($num, $address);
        $this->dontSeeInEmailSubject($email, $unexpected);
    }

    /**
     * Grab Matches From Nth Email
     *
     * Look for a regex in the email source and return it's matches
     *
     * @return array
     **/
    public function grabMatchesFromNthEmail($num, $regex)
    {
        $email = $this->nthMessage($num);
        $matches = $this->grabMatchesFromEmail($email, $regex);

        return $matches;
    }

    /**
     * Grab From Nth Email
     *
     * Look for a regex in the email source and return it
     *
     * @return string
     **/
    public function grabFromNthEmail($num, $regex)
    {
        $matches = $this->grabMatchesFromNthEmail($num, $regex);

        return $matches[0];
    }

    /**
     * Grab Matches From Nth Email To
     *
     * Look for a regex in most recent email sent to $addres email source and
     * return it's matches
     *
     * @return array
     **/
    public function grabMatchesFromNthEmailTo($num, $address, $regex)
    {
        $email = $this->nthMessageFrom($num, $address);
        $matches = $this->grabMatchesFromEmail($email, $regex);

        return $matches;
    }

    /**
     * Grab From Nth Email To
     *
     * Look for a regex in most recent email sent to $addres email source and
     * return it
     *
     * @return string
     **/
    public function grabFromNthEmailTo($num, $address, $regex)
    {
        $matches = $this->grabMatchesFromNthEmailTo($num, $address, $regex);

        return $matches[0];
    }

    /**
     * See In Last Email subject
     *
     * Look for a string in the most recent email subject
     *
     **/
    public function seeInLastEmailSubject($expected)
    {
        $email = $this->lastMessage();
        $this->seeInEmailSubject($email, $expected);
    }

    /**
     * Don't See In Last Email subject
     *
     * Look for the absence of a string in the most recent email subject
     *
     * @return void
     **/
    public function dontSeeInLastEmailSubject($expected)
    {
        $email = $this->lastMessage();
        $this->dontSeeInEmailSubject($email, $expected);
    }

    /**
     * Don't See In Last Email
     *
     * Look for the absence of a string in the most recent email
     *
     * @return void
     **/
    public function dontSeeInLastEmail($unexpected)
    {
        $email = $this->lastMessage();
        $this->dontSeeInEmail($email, $unexpected);
    }

    /**
     * See In Last Email To
     *
     * Look for a string in the most recent email sent to $address
     *
     **/
    public function seeInLastEmailTo($address, $expected)
    {
        $email = $this->lastMessageFrom($address);
        $this->seeInEmail($email, $expected);

    }

    /**
     * Don't See In Last Email To
     *
     * Look for the absence of a string in the most recent email sent to $address
     *
     * @return void
     **/
    public function dontSeeInLastEmailTo($address, $unexpected)
    {
        $email = $this->lastMessageFrom($address);
        $this->dontSeeInEmail($email, $unexpected);
    }

    /**
     * See In Last Email Subject To
     *
     * Look for a string in the most recent email subject sent to $address
     *
     **/
    public function seeInLastEmailSubjectTo($address, $expected)
    {
        $email = $this->lastMessageFrom($address);
        $this->seeInEmailSubject($email, $expected);

    }

    /**
     * Don't See In Last Email Subject To
     *
     * Look for the absence of a string in the most recent email subject sent to $address
     *
     * @return void
     **/
    public function dontSeeInLastEmailSubjectTo($address, $unexpected)
    {
        $email = $this->lastMessageFrom($address);
        $this->dontSeeInEmailSubject($email, $unexpected);
    }

    /**
     * Grab Matches From Last Email
     *
     * Look for a regex in the email source and return it's matches
     *
     **/
    public function grabMatchesFromLastEmail($regex)
    {
        $email = $this->lastMessage();
        $matches = $this->grabMatchesFromEmail($email, $regex);

        return $matches;
    }

    /**
     * Grab From Last Email
     *
     * Look for a regex in the email source and return it
     *
     **/
    public function grabFromLastEmail($regex)
    {
        $matches = $this->grabMatchesFromLastEmail($regex);

        return $matches[0];
    }

    /**
     * Grab Matches From Last Email To
     *
     * Look for a regex in most recent email sent to $addres email source and
     * return it's matches
     *
     **/
    public function grabMatchesFromLastEmailTo($address, $regex)
    {
        $email = $this->lastMessageFrom($address);
        $matches = $this->grabMatchesFromEmail($email, $regex);

        return $matches;
    }

    /**
     * Grab From Last Email To
     *
     * Look for a regex in most recent email sent to $addres email source and
     * return it
     *
     **/
    public function grabFromLastEmailTo($address, $regex)
    {
        $matches = $this->grabMatchesFromLastEmailTo($address, $regex);

        return $matches[0];
    }

    /**
     * Test email count equals expected value
     *
     * @return void
     **/
    public function seeEmailCount($expected)
    {
        $messages = $this->messages();
        $count = count($messages);
        $this->assertEquals($expected, $count);
    }


    /**
     * Messages
     *
     * Get an array of all the message objects
     *
     * @return array
     **/
    protected function messages()
    {
        $response = $this->mailcatcher->request('GET', '/messages');
        $messages = json_decode($response->getBody()->getContents(), true);
        usort($messages, array($this, 'messageSortCompare'));

        return $messages;
    }

    /**
     * Last Message
     *
     * Get the most recent email
     *
     * @return obj
     **/
    protected function lastMessage()
    {
        $messages = $this->messages();
        if (empty($messages)) {
            $this->fail("No messages received");
        }

        $last = array_shift($messages);

        return $this->emailFromId($last['id']);
    }

    /**
     * Last Message From
     *
     * Get the most recent email sent to $address
     *
     * @return obj
     **/
    protected function lastMessageFrom($address)
    {
        $ids = [];
        $messages = $this->messages();
        if (empty($messages)) {
            $this->fail("No messages received");
        }

        foreach ($messages as $message) {
            foreach ($message['recipients'] as $recipient) {
                if (strpos($recipient, $address) !== false) {
                    $ids[] = $message['id'];
                }
            }
        }

        if (count($ids) > 0) {
            return $this->emailFromId(max($ids));
        }

        $this->fail("No messages sent to {$address}");
    }

    /**
     * Email from ID
     *
     * Given a mailcatcher id, returns the email's object
     *
     **/
    protected function emailFromId($id)
    {
        $response = $this->mailcatcher->request('GET', "/messages/{$id}.json");
        $message = json_decode($response->getBody()->getContents(), true);
        $message['source'] = quoted_printable_decode($message['source']);

        return $message;
    }

    /**
     * See In Subject
     *
     * Look for a string in an email subject
     *
     * @return void
     **/
    protected function seeInEmailSubject($email, $expected)
    {
        $this->assertContains($expected, $email['subject'], "Email Subject Contains");
    }

    /**
     * Don't See In Subject
     *
     * Look for the absence of a string in an email subject
     *
     * @return void
     **/
    protected function dontSeeInEmailSubject($email, $unexpected)
    {
        $this->assertNotContains($unexpected, $email['subject'], "Email Subject Does Not Contain");
    }

    /**
     * See In Email
     *
     * Look for a string in an email
     *
     * @return void
     **/
    protected function seeInEmail($email, $expected)
    {
        $this->assertContains($expected, $email['source'], "Email Contains");
    }

    /**
     * Don't See In Email
     *
     * Look for the absence of a string in an email
     *
     * @return void
     **/
    protected function dontSeeInEmail($email, $unexpected)
    {
        $this->assertNotContains($unexpected, $email['source'], "Email Does Not Contain");
    }

    /**
     * Grab From Email
     *
     * Return the matches of a regex against the raw email
     *
     **/
    protected function grabMatchesFromEmail($email, $regex)
    {
        preg_match($regex, $email['source'], $matches);
        $this->assertNotEmpty($matches, "No matches found for $regex");

        return $matches;
    }

    static function messageSortCompare($messageA, $messageB)
    {
        $sortKeyA = $messageA['created_at'] . $messageA['id'];
        $sortKeyB = $messageB['created_at'] . $messageB['id'];

        return ($sortKeyA > $sortKeyB) ? -1 : 1;
    }


    /**
     * Last Message
     *
     * Get Nth($num) email
     *
     * @return obj
     **/
    protected function nthMessage($key = null)
    {
        $messages = $this->messages();
        if (empty($messages)) {
            $this->fail("No messages received");
        }
        if (is_null($key)) {
            $this->fail("You need to provide a number to be used as the index key.");
        }
        $target = $messages[$key];

        return $this->emailFromId($target['id']);
    }

    /**
     * Nth($num) Message From
     *
     * Get the Nth($num) sent to $address
     *
     * @return obj
     **/
    protected function nthMessageFrom($key = null, $address)
    {
        $ids = [];
        $messages = $this->messages();
        if (empty($messages)) {
            $this->fail("No messages received");
        }
        if (is_null($key)) {
            $this->fail("You need to provide a number to be used as the index key.");
        }
        foreach ($messages as $message) {
            foreach ($message['recipients'] as $recipient) {
                if (strpos($recipient, $address) !== false) {
                    $ids[] = $message['id'];
                }
            }
        }
        if (count($ids) > 0) {
            return $this->emailFromId($ids[$key]);
        }
        $this->fail("No messages sent to {$address}");
    }

}
