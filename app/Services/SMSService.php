<?php


namespace App\Services;

use Aws\Credentials\Credentials;
use Aws\Exception\AwsException;
use Aws\Sns\SnsClient;

class SMSService
{
    public function send($phone, $message)
    {
        dump('AWS_ACCESS_KEY_ID:' . env('AWS_ACCESS_KEY_ID'));
        dump('AWS_SECRET_ACCESS_KEY:' . env('AWS_SECRET_ACCESS_KEY'));
        $credentials = new Credentials(env('AWS_ACCESS_KEY_ID'), env('AWS_SECRET_ACCESS_KEY'));

        $SnsClient = new SnsClient([
            'credentials' => $credentials,
            'region' => 'us-east-1',
            'version' => '2010-03-31'
        ]);

        try {
            $result = $SnsClient->publish([
                'Message' => $message,
                'PhoneNumber' => $phone,
                'MessageAttributes' => [
                    'AWS.SNS.SMS.SMSType'  => [
                        'DataType'    => 'String',
                        'StringValue' => 'Transactional',
                    ]
                ],
            ]);
            dump('result', $result);
        } catch (AwsException $e) {
            dump('error', $e->getMessage());
        }
    }
}
