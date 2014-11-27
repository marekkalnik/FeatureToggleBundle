<?php
namespace Emka\FeatureToggleBundle\Twig;

use Emka\FeatureToggleBundle\Feature\FeatureManager;
use Emka\FeatureToggleBundle\Exception\FeatureToggleNotFoundException;

/**
 * Parses a feature tag
 *
 * @author Marek Kalnik <marekk@theodo.fr>
 * @author Benjamin Grandfond <benjaming@theodo.fr>
 * @since  2011-09-17
 *
 * {% feature name %}
 * code
 * {% endfeature %}
 * ---- EQUALS --------
 * {% if feature_enabled(name) === true %}
 * code
 * {% endif %}
 */
class FeatureToggleTokenParser extends \Twig_TokenParser
{
    protected $manager;

    /**
     * @param \Emka\FeatureToggleBundle\Feature\FeatureManager $manager
     */
    public function __construct(FeatureManager $manager)
    {
        $this->manager = $manager;
    }

    public function parse(\Twig_Token $token)
    {
        $name   = null;

        $stream = $this->parser->getStream();
        while (!$stream->test(\Twig_Token::BLOCK_END_TYPE)) {
            if ($stream->test(\Twig_Token::STRING_TYPE)) {
                $name = $stream->next()->getValue();

                if (!$this->manager->has($name)) {
                    throw new FeatureToggleNotFoundException(sprintf('The feature "%s" does not exist.', $name));
                } else {
                    $feature = $this->manager->get($name);
                }
            } else {
                $token = $stream->getCurrent();
                throw new \Twig_Error_Syntax(sprintf('Unexpected token "%s" of value %s".', \Twig_Token::typeToEnglish($token->getType(), $token->getLine()), $token->getValue()), $token->getLine());
            }
        }

        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        // Store the body of the feature.
        $body = $this->parser->subparse(array($this, 'decideFeatureEnd'), true);

        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        if ($feature->isEnabled()) {
            return $body;
        }

        return;
    }

    /**
     * Test whether the feature is ended or not.
     *
     * @param \Twig_Token $token
     * @return bool
     */
    public function decideFeatureEnd(\Twig_Token $token)
    {
        return $token->test($this->getEndTag());
    }

    /**
     * Return the tag that marks the beginning of a feature.
     *
     * @return string
     */
    public function getTag()
    {
        return 'feature';
    }

    /**
     * Return the tag that marks the end of the feature.
     *
     * @return string
     */
    public function getEndTag()
    {
        return 'end'.$this->getTag();
    }
}
