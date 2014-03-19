<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class ListHeader extends AbstractHelper
{

    public function __invoke($title = 'List', $action = '')
    {
        $html = '<div class="list-header">';
        $html .='<div class="title"><h3>' . $title . '</h3></div>';
        $html .='<div class="add-button"><a href="' . $action . '" class="btn btn-primary add">Add</a></div>';
        $html .= '</div>';

        return $html;
    }

}
