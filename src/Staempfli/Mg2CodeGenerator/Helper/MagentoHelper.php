<?php
/**
 * MagentoHelper
 *
 * @copyright Copyright (c) 2016 Staempfli AG
 * @author    juan.alonso@staempfli.com
 */

namespace Staempfli\Mg2CodeGenerator\Helper;

use Staempfli\UniversalGenerator\Helper\FileHelper;

class MagentoHelper
{
    protected $moduleRegistrationFile = 'registration.php';

    /**
     * Check if module exists to generate code into it
     *
     * @return bool
     */
    public function moduleExist()
    {
        $fileHelper = new FileHelper();
        return file_exists($fileHelper->getModuleDir() . '/' . $this->moduleRegistrationFile);
    }

    /**
     * Get module properties
     *
     * @throws \Exception
     */
    public function getModuleProperties()
    {
        if (!$this->moduleExist()) {
            $message = 'registration.php not existing at current dir. Please check that your registration.php is correct and try again';
            throw new \Exception($message);
        }

        $moduleProperties = [];
        $fileHelper = new FileHelper();
        $registrationContent = file_get_contents($fileHelper->getModuleDir() . '/' . $this->moduleRegistrationFile);
        $moduleProperties['Vendorname'] = preg_match("/[',\"](.*?)_/", $registrationContent, $match) ? $match[1] : false;
        $moduleProperties['Modulename'] = preg_match("/_(.*?)[',\"]/", $registrationContent, $match) ? $match[1] : false;
        if (!$moduleProperties) {
            $message = 'VendorName and ModuleName could not be found on registration.php. Please check that your registration.php is correct and try again';
            throw new \Exception($message);
        }

        return $moduleProperties;
    }
}