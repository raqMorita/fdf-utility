<?php
/**
 * @file
 * ChoiceField.php
 */

namespace Wesnick\FdfUtility\Fields;


use Wesnick\FdfUtility\FdfWriter;

class ChoiceField extends PdfField
{

    public function getEscapedValue()
    {
        if ($this->isMultiSelect() && is_array($this->value)) {
            $out = '';
            foreach ($this->value as $val) {
                $out .= '(' . FdfWriter::escapePdfName($val) . ')';
            }
            return '[ ' . $out . ' ]';
        } else {
            return '(' . FdfWriter::escapePdfName($this->value) . ')';
        }
    }

    /**
     * @return string
     */
    public function getExampleValue()
    {
        if ($this->isEditableList()) {
            return 'Edited Value';
        }

        if ($this->isMultiSelect()) {
            return $this->options;
        }

        $keys = array_keys($this->options);
        return $this->options[$keys[mt_rand(0, (count($keys) - 1))]];
    }

    public function isMultiSelect()
    {
        return $this->checkBitValue(PdfField::MULTI_SELECT);
    }

    public function isComboBox()
    {
        return $this->checkBitValue(PdfField::COMBO_BOX);
    }

    public function isListBox()
    {
        return ! $this->checkBitValue(PdfField::COMBO_BOX);
    }

    public function isEditableList()
    {
        return $this->checkBitValue(PdfField::EDITABLE_LIST) && $this->isComboBox();
    }

    public function isSortedList()
    {
        return $this->checkBitValue(PdfField::SORTED_LIST);
    }

    public function isCommitOnChange()
    {
        return $this->checkBitValue(PdfField::COMMIT_ON_CHANGE);
    }

    public function isNoSpellCheck()
    {
        return $this->checkBitValue(PdfField::NO_SPELL_CHECK);
    }

}