<?php namespace DCarbone;

if (interface_exists('JsonSerializable'))
{
    /**
     * Interface JsonSerializable
     * @package DCarbone
     */
    interface JsonSerializable extends \JsonSerializable {}
}
else
{
    /**
     * Interface JsonSerializable
     * @package DCarbone
     */
    interface JsonSerializable
    {
        /**
         * @return array
         */
        public function jsonSerialize();
    }
}