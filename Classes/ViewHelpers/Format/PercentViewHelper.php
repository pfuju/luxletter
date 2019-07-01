<?php
declare(strict_types=1);
namespace In2code\Luxletter\ViewHelpers\Format;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class PercentViewHelper
 */
class PercentViewHelper extends AbstractViewHelper
{

    /**
     * @return void
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('number', 'float', 'Any number', true);
        $this->registerArgument('decimals', 'int', 'The number of digits after the decimal point', false, 1);
        $this->registerArgument('postfix', 'string', 'Any postfix like a percent sign', false, ' %');
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $value = $this->arguments['number'] * 100;
        $value = number_format($value, $this->arguments['decimals']);
        return (string)$value . $this->arguments['postfix'];
    }
}
