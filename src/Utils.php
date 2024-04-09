<?php

namespace Nalgoo\Logging;

class Utils
{
	/**
	 * This method is taken from Monolog package
	 * @author Jordi Boggiano <j.boggiano@seld.be>
	 */
	public static function getClass(object $object): string
    {
        $class = \get_class($object);

        if (false === ($pos = \strpos($class, "@anonymous\0"))) {
            return $class;
        }

        if (false === ($parent = \get_parent_class($class))) {
            return \substr($class, 0, $pos + 10);
        }

        return $parent . '@anonymous';
    }
}