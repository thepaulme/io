<?php
namespace io\Routing;

class RouteCompiler {

	const REGEX_DELIMITER = '#';

	const SEPARATORS = '/,;.:-_~+*=@|';

	const VARIABLE_MAXIMUM_LENGTH = 32;

	public function compile (Route $route) {
		$tokens = [];
		$variables = [];
		$pos = 0;
		$defaultSeparator = "/";

		$pattern = $route -> uri;

		preg_match_all (self::REGEX_DELIMITER . '\{\w+\}' . self::REGEX_DELIMITER, $pattern, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
        foreach ($matches as $match) {
			$varName = substr ($match[0][0], 1, -1);
			$precedingText = substr ($pattern, $pos, $match[0][1] - $pos);
			$pos = $match[0][1] + \strlen ($match[0][0]);

			if (preg_match ('/^\d/', $varName)) {
				throw new \DomainException (sprintf('Variable name "%s" cannot start with a digit in route pattern "%s". Please use a different name.', $varName, $pattern));
			}

			if (\in_array ($varName, $variables)) {
				throw new \LogicException (sprintf('Route pattern "%s" cannot reference variable name "%s" more than once.', $pattern, $varName));
			}

            if (\strlen ($varName) > self::VARIABLE_MAXIMUM_LENGTH) {
                throw new \DomainException (sprintf ('Variable name "%s" cannot be longer than %s characters in route pattern "%s". Please use a shorter name.', $varName, self::VARIABLE_MAXIMUM_LENGTH, $pattern));
            }

/*
			if ($isSeparator && $precedingText !== $precedingChar) {
				$tokens[] = array('text', substr($precedingText, 0, -\strlen($precedingChar)));
			} elseif (!$isSeparator && \strlen($precedingText) > 0) {
				$tokens[] = array('text', $precedingText);
			}
*/


			$regexp = $route -> getWhere ($varName);

			if (null === $regexp) {
				$regexp = ".*";
			}

			if ('' !== $precedingText) {
				$tokens[] = array ('text', $precedingText);
			}

			$tokens[] = array ('variable', $regexp, $varName);
			$variables[] = $varName;           
		}
// echo $pos . " ::: " . strlen ($pattern);
// echo "\n";

        if ($pos < \strlen ($pattern)) {
            $tokens[] = array('text', substr ($pattern, $pos));
        }

		$regexp = self::REGEX_DELIMITER . '^' . $this -> computeRegexp ($tokens) . '$' . self::REGEX_DELIMITER . 'sD';
// echo "\n";
		return new CompiledRoute (
			$regexp,
			$tokens,
			$variables
		);
	}

	private function computeRegexp ($tokens) {
		for ($i = 0; $i < count ($tokens); ++$i) {
			if ('text' == $tokens[$i][0]) {
				$regexp .= $tokens[$i][1];
			} else {
				$regexp .= "(" . $tokens[$i][1] . ")";
			}
		}

		return $regexp;
	}

}