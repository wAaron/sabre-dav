<?php

namespace Sabre\DAV\Xml\Property;

use
    Sabre\Xml\Element,
    Sabre\Xml\Reader,
    Sabre\Xml\Writer,
    Sabre\DAV\Exception\CannotSerialize;

/**
 * {DAV:}resourcetype property
 *
 * This class represents the {DAV:}resourcetype property, as defined in:
 *
 * https://tools.ietf.org/html/rfc4918#section-15.9
 *
 * @copyright Copyright (C) 2007-2015 fruux GmbH (https://fruux.com/).
 * @author Evert Pot (http://evertpot.com/)
 * @license http://sabre.io/license/ Modified BSD License
 */
class ResourceType extends Element\Elements {

    /**
     * Constructor
     *
     * You can either pass null (for no resourcetype), a string (for a single
     * resourcetype) or an array (for multiple).
     *
     * The resourcetype must be specified in clark-notation
     *
     * @param array|string|null $resourceType
     */
    function __construct($resourceTypes = null) {

        if (is_null($resourceTypes)) {
            parent::__construct([]);
        } elseif (is_array($resourceTypes)) {
            parent::__construct($resourceTypes);
        } else {
            parent::__construct([$resourceTypes]);
        }

    }

    /**
     * Returns the values in clark-notation
     *
     * For example array('{DAV:}collection')
     *
     * @return array
     */
    function getValue() {

        return $this->value;

    }

    /**
     * Checks if the principal contains a certain value
     *
     * @param string $type
     * @return bool
     */
    function is($type) {

        return in_array($type, $this->value);

    }

    /**
     * Adds a resourcetype value to this property
     *
     * @param string $type
     * @return void
     */
    function add($type) {

        $this->value[] = $type;
        $this->value = array_unique($this->value);

    }

    /**
     * The deserialize method is called during xml parsing.
     *
     * This method is called statictly, this is because in theory this method
     * may be used as a type of constructor, or factory method.
     *
     * Often you want to return an instance of the current class, but you are
     * free to return other data as well.
     *
     * Important note 2: You are responsible for advancing the reader to the
     * next element. Not doing anything will result in a never-ending loop.
     *
     * If you just want to skip parsing for this element altogether, you can
     * just call $reader->next();
     *
     * $reader->parseInnerTree() will parse the entire sub-tree, and advance to
     * the next element.
     *
     * @param Reader $reader
     * @return mixed
     */
    static function xmlDeserialize(Reader $reader) {

        return
            new self(parent::xmlDeserialize($reader));

    }

}
