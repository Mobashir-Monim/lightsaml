<?php

namespace LightSaml\Model\Metadata;

use LightSaml\Error\LightSamlNameIDFormatException;
use LightSaml\Model\Context\DeserializationContext;
use LightSaml\Model\Context\SerializationContext;
use LightSaml\SamlConstants;

class NameIDFormatDescriptor extends AbstractSamlModel
{
    /** @var string */
    protected $format;

    /**
     * @param NameIDFormat $format
     */
    public function __construct($format = SamlConstants::NAME_ID_FORMAT_UNSPECIFIED)
    {
        $this->format = $format;
    }

    /**
     * @param NameIDFormat $format
     */
    public function setNameIDFormat($format)
    {
        if (true === SamlConstants::isNameIdFormatValid($format)) {
            $this->format = $format;
        } else {
            throw new LightSamlNameIDFormatException(sprintf(
                "Invalid NameIDFormat value '%s', must be within the following values: '%s' ",
                $format,
                implode(', ', SamlConstants::getValidNameIDFormats())
            ));
        }
    }

    public function getNameIDFormat()
    {
        return $this->format;
    }

    /**
     * @param \DOMNode             $parent
     * @param SerializationContext $context
     *
     * @return void
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $result = $this->createElement('NameIDFormat', SamlConstants::NS_METADATA, $parent, $context);

        $result->nodeValue = $this->getNameIDFormat();
    }

    /**
     * @param \DOMNode               $node
     * @param DeserializationContext $context
     */
    public function deserialize(\DOMNode $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'NameIDFormat', SamlConstants::NS_METADATA);

        $this->setNameIDFormat(trim($node->textContent));
    }
}