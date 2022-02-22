<?php

namespace NotificationChannels\AwsSns;

use Aws\Exception\AwsException;
use Aws\Sns\SnsClient as SnsService;

class Sns
{
    /**
     * @var SnsService
     */
    protected $snsService;

    public function __construct(SnsService $snsService)
    {
        $this->snsService = $snsService;
    }

    /**
     * @param  string  $destination  Phone number as described by the E.164 format.
     * @return \Aws\Result
     *
     * @throws AwsException
     */
    public function send(SnsMessage $message, $destination)
    {
        $attributes = [
            'AWS.SNS.SMS.SMSType' => [
                'DataType' => 'String',
                'StringValue' => $message->getDeliveryType(),
            ],
        ];

        if (! empty($message->getSender())) {
            $attributes += [
                'AWS.SNS.SMS.SenderID' => [
                    'DataType' => 'String',
                    'StringValue' => $message->getSender(),
                ],
            ];
        }

        if (! empty($message->getOriginationNumber())) {
            $attributes += [
                'AWS.MM.SMS.OriginationNumber' => [
                    'DataType' => 'String',
                    'StringValue' => $message->getOriginationNumber(),
                ],
            ];
        }

        $parameters = [
            'Message' => $message->getBody(),
            'PhoneNumber' => $destination,
            'MessageAttributes' => $attributes,
        ];

        return $this->snsService->publish($parameters);
    }
}
