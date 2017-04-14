<?php

namespace Hidehalo\Emoji\Features;

use Hidehalo\Emoji\Features\Protocol\ProtocolInterface;

class ProtocolFactory
{
    private static $protocolInstancesMap = [];

    public static final function generate($protocolName, array $options = [])
    {
        try {
            $reflector = new \ReflectionClass($protocolName);
            $interfaces = $reflector->getInterfaceNames();
            $interfacesCount = array_count_values($interfaces);
            $isImplementsOf = isset($interfacesCount[ProtocolInterface::class]) ? true : false;
        } catch (\ReflectionException $e) {
           throw new \Exception('Can not found protocol '.$protocolName);
        }

        if (class_exists($protocolName) && $isImplementsOf) {

            if (isset(self::$protocolInstancesMap[$protocolName])
                && self::$protocolInstancesMap[$protocolName] instanceof ProtocolInterface) {

                return self::$protocolInstancesMap[$protocolName];
            } elseif (!isset(self::$protocolInstancesMap[$protocolName])) {
                self::$protocolInstancesMap[$protocolName] = new $protocolName($options);

                return self::$protocolInstancesMap[$protocolName];
            } else {
                // @codeCoverageIgnoreStart
                unset(self::$protocolInstancesMap[$protocolName]);
                self::$protocolInstancesMap[$protocolName] = new $protocolName($options);

                return self::$protocolInstancesMap[$protocolName];
                // @codeCoverageIgnoreEnd
            }
        }
    }
}