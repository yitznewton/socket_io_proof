<?php

namespace EasyBib\Scholar\Message;

class NotecardUpdateDecoder
{
    /**
     * @param string $rawMessage 
     * @return array
     */
    public function decode($rawMessage)
    {
        $decoded = json_decode($rawMessage, true);

        if (!is_array($decoded)) {
            return null;
        }

        $expectedKeys = [
            'project_id',
            'notecard_id',
            'text',
        ];

        $expectedArray = array_combine($expectedKeys, $expectedKeys);

        if (array_diff_key($expectedArray, $decoded)) {
            return null;
        }

        return $decoded;
    }
}
