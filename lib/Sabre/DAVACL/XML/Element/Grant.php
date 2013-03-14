<?php

namespace Sabre\DAVACL\XML\Element;

use
    Sabre\XML\Element,
    Sabre\XML\Reader,
    Sabre\XML\Writer,
    Sabre\DAV\Exception\CannotSerialize;

/**
 * Grant
 *
 * This class the {DAV:}grant element, as defined in:
 *
 * http://tools.ietf.org/html/rfc3744#section-5.5.2
 *
 * The deserializer just returns the privileges as an array.
 *
 * @copyright Copyright (C) 2007-2013 Rooftop Solutions. All rights reserved.
 * @author Evert Pot (http://www.rooftopsolutions.nl/)
 * @license http://code.google.com/p/sabredav/wiki/License Modified BSD License
 */
class Grant implements Element {

    /**
     * The serialize method is called during xml writing.
     *
     * It should use the $writer argument to encode this object into XML.
     *
     * Important note: it is not needed to create the parent element. The
     * parent element is already created, and we only have to worry about
     * attributes, child elements and text (if any).
     *
     * Important note 2: If you are writing any new elements, you are also
     * responsible for closing them.
     *
     * @param Writer $writer
     * @return void
     */
    public function serializeXml(Writer $writer) {

        throw new CannotSerialize('This element cannot be serialized.');

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
    static public function deserializeXml(Reader $reader) {

        $privileges = [];

        foreach($reader->parseInnerTree() as $elem) {

            if ($elem['name'] === '{DAV:}privilege') {

                if ($elem['value']) foreach($elem['value'] as $privElem) {

                    $privileges[] = $privElem['name'];

                }

            }

        }
        return $privileges;

    }

}
