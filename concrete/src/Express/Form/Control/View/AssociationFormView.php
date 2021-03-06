<?php
namespace Concrete\Core\Express\Form\Control\View;

use Concrete\Core\Entity\Express\Control\AssociationControl;
use Concrete\Core\Entity\Express\Control\Control;
use Concrete\Core\Express\Form\Context\ContextInterface;
use Concrete\Core\Filesystem\TemplateLocator;

class AssociationFormView extends AssociationView
{
    protected $association;

    public function __construct(ContextInterface $context, Control $control)
    {
        parent::__construct($context, $control);
        $this->addScopeItem('allEntries', $this->allEntries);
        $this->addScopeItem('selectedEntries', $this->selectedEntries);

        // @deprecated – use allEntries and selectedEntries instead
        $this->addScopeItem('entities', $this->allEntries);
        $this->addScopeItem('selectedEntities', $this->selectedEntries);
    }

    /**
     * @param AssociationControl $control
     *
     * @return string
     */
    protected function getFormFieldElement(AssociationControl $control)
    {
        $mode = $control->getEntrySelectorMode();
        $class = get_class($control->getAssociation());
        $class = strtolower(str_replace(['Concrete\\Core\\Entity\\Express\\', 'Association'], '', $class));
        if ('many' == substr($class, -4)) {
            if (AssociationControl::TYPE_ENTRY_SELECTOR == $mode) {
                return 'entry_selector_multiple';
            } else {
                return 'select_multiple';
            }
        } else {
            if (AssociationControl::TYPE_ENTRY_SELECTOR == $mode) {
                return 'entry_selector';
            } else {
                return 'select';
            }
        }
    }

    public function createTemplateLocator()
    {
        // Is this an owning entity with display order? If so, we render a separate reordering control
        $element = $this->getFormFieldElement($this->control);
        $association = $this->association;
        if ($association->isOwningAssociation()) {
            $element = 'view';
        }
        $locator = new TemplateLocator('association/' . $element);

        return $locator;
    }
}
