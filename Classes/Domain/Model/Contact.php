<?php
namespace Slub\MahuPartners\Domain\Model;

use TYPO3\CMS\Backend\Utility\BackendUtility;

/***
 *
 * This file is part of the "MaHu Frontend" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Carsten Radeck <carsten.radeck@slub-dresden.de>, SLUB Dresden
 *
 ***/

/**
 * Contact
 */
class Contact extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * surname
     * 
     * @var string
     */
    protected $surname = '';

    /**
     * familyname
     * 
     * @var string
     */
    protected $familyname = '';

    /**
     * title
     * 
     * @var string
     */
    protected $title = '';

    /**
     * position
     * 
     * @var string
     */
    protected $position = '';

    /**
     * phone
     * 
     * @var string
     */
    protected $phone = '';

    /**
     * email
     * 
     * @var string
     */
    protected $email = '';

    /**
     * fax
     * 
     * @var string
     */
    protected $fax = '';

    /**
     * materialClasses
     * 
     * @var string
     */
    protected $materialClasses = 0;

    /**
     * accounts
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Slub\MahuPartners\Domain\Model\SocialNetworkAccount>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $accounts = null;

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     * 
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->accounts = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the surname
     * 
     * @return string $surname
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Sets the surname
     * 
     * @param string $surname
     * @return void
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * Returns the familyname
     * 
     * @return string $familyname
     */
    public function getFamilyname()
    {
        return $this->familyname;
    }

    /**
     * Sets the familyname
     * 
     * @param string $familyname
     * @return void
     */
    public function setFamilyname($familyname)
    {
        $this->familyname = $familyname;
    }

    /**
     * Returns the title
     * 
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     * 
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the position
     * 
     * @return string $position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Sets the position
     * 
     * @param string $position
     * @return void
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * Returns the phone
     * 
     * @return string $phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Sets the phone
     * 
     * @param string $phone
     * @return void
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Returns the email
     * 
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the email
     * 
     * @param string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Returns the fax
     * 
     * @return string $fax
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Sets the fax
     * 
     * @param string $fax
     * @return void
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * Adds a SocialNetworkAccount
     * 
     * @param \Slub\MahuPartners\Domain\Model\SocialNetworkAccount $account
     * @return void
     */
    public function addAccount(\Slub\MahuPartners\Domain\Model\SocialNetworkAccount $account)
    {
        $this->accounts->attach($account);
    }

    /**
     * Removes a SocialNetworkAccount
     * 
     * @param \Slub\MahuPartners\Domain\Model\SocialNetworkAccount $accountToRemove The SocialNetworkAccount to be removed
     * @return void
     */
    public function removeAccount(\Slub\MahuPartners\Domain\Model\SocialNetworkAccount $accountToRemove)
    {
        $this->accounts->detach($accountToRemove);
    }

    /**
     * Returns the accounts
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Slub\MahuPartners\Domain\Model\SocialNetworkAccount> $accounts
     */
    public function getAccounts()
    {
        return $this->accounts;
    }

    /**
     * Sets the accounts
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Slub\MahuPartners\Domain\Model\SocialNetworkAccount> $accounts
     * @return void
     */
    public function setAccounts(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $accounts)
    {
        $this->accounts = $accounts;
    }

    /**
     * Returns the materialClasses
     * 
     * @return string materialClasses
     */
    public function getMaterialClasses()
    {
        return $this->materialClasses;
    }

    /**
     * Sets the materialClasses
     * 
     * @param int $materialClasses
     * @return void
     */
    public function setMaterialClasses($materialClasses)
    {
        $this->materialClasses = $materialClasses;
    }
    
    /** Helper method that generates a label for a company shown in the TYPO3 backend */
    public function getLabel(&$parameters){
        $record = BackendUtility::getRecord($parameters['table'], $parameters['row']['uid']);
        
        $label = "";
        if ($record['surname']){
            $label= $record['surname'];
        }
        if ($record['familyname']){
            $label= $label." ".$record['familyname'];
        }
        if ($record['email']) {
            if (empty($label)){
                $label = $record['email'];
            } else {
                $label = $label." (".$record['email'].")";
            }
        }
        $parameters['title'] = $label;
    }
}
