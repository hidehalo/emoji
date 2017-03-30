<?php

namespace Hidehalo\Emoji\Features;

use Hidehalo\Emoji\Features\Protocol\ProtocolInterface;

class ProtocolFactory
{
    private static $protocolInstancesMap = [];

    public static final function generate($protocolName, array $options = [])
    {
        $reflector = new \ReflectionClass($protocolName);
        $interfaces = $reflector->getInterfaceNames();
        $interfacesCount = array_count_values($interfaces);
        $isImplementsOf = isset($interfacesCount[ProtocolInterface::class]) ? true : false;

        if (class_exists($protocolName) && $isImplementsOf) {

            if (isset(self::$protocolInstancesMap[$protocolName])
                && self::$protocolInstancesMap[$protocolName] instanceof ProtocolInterface) {

                return self::$protocolInstancesMap[$protocolName];
            } elseif (!isset(self::$protocolInstancesMap[$protocolName])) {
                self::$protocolInstancesMap[$protocolName] = new $protocolName($options);

                return self::$protocolInstancesMap[$protocolName];
            } else {
                unset(self::$protocolInstancesMap[$protocolName]);
                self::$protocolInstancesMap[$protocolName] = new $protocolName($options);

                return self::$protocolInstancesMap[$protocolName];
            }
        }

        throw new \Exception('Can not found protocol '.$protocolName);
    }
}