<?php
/**
 * Parses a feature tag
 *
 * @author Marek Kalnik <marekk@theodo.fr>
 * @since  2011-09-17
 *
 * {% feature name %}
 * code
 * {% endfeature %}
 * ---- EQUALS --------
 * {% if feature_enabled(name) == false %}
 *   <div class="feature-disabled">
 * {% endif %}
 * code
 * {% if feature_enabled(name) == false %}
 *   <div class="feature-disabled">
 * {% endif %}
 */
class Twig_Extensions_TokenParser_FeatureToggle extends Twig_TokenParser
{
    public function parse(Twig_Token $token) {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $name   = $stream->expect(Twig_Token::NAME_TYPE)->getValue();

        $this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);
        if ($stream->test(Twig_Token::BLOCK_END_TYPE)) {
            $stream->next();

            $body = $this->parser->subparse(array($this, 'decideBlockEnd'), true);
            if ($stream->test(Twig_Token::NAME_TYPE)) {
                $value = $stream->next()->getValue();

                if ($value != $name) {
                    throw new Twig_Error_Syntax(sprintf("Expected endblock for block '$name' (but %s given)", $value), $lineno);
                }
            }
        }
    }

    public function decideFeatureEnd(Twig_Token $token) {
        return $token->test('endfeature');
    }

    public function getTag() {
        return 'feature';
    }
}
