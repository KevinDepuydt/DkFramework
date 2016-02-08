<?php
/**
 * Created by PhpStorm.
 * User: Kévin
 * Date: 06/02/2016
 * Time: 16:27
 */

namespace Core\Controllers;

class ModuleController extends Controller
{

    public function __construct($moduleName)
    {
        parent::__construct();
        $this->tpl->addTemplateDir('modules/'.$moduleName.'/views/', $moduleName);
        $this->tpl->addBootstrap();
        $this->tpl->addFontAwesome();
    }
}