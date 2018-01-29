<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CampaignListRepository")
 */
class CampaignList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="list_id", type="string", length=255, unique=true)
     */
    private $listId;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(name="company", type="string", length=255)
     */
    private $company;

    /**
     * @ORM\Column(name="address1", type="string", length=255)
     */
    private $address1;

    /**
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(name="state", type="string", length=255)
     */
    private $state;

    /**
     * @ORM\Column(name="zip", type="string", length=255)
     */
    private $zip;

    /**
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;

    /**
     * @ORM\Column(name="permission_reminder", type="string", length=255)
     */
    private $permissionReminder;

    /**
     * @ORM\Column(name="from_name", type="string", length=255)
     */
    private $fromName;

    /**
     * @ORM\Column(name="from_email", type="string", length=255)
     */
    private $fromEmail;

    /**
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @ORM\Column(name="language", type="string", length=255)
     */
    private $language;

    /**
     * @ORM\Column(name="email_type_option", type="boolean")
     */
    private $emailTypeOption;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Member", mappedBy="list", cascade={"remove"})
     */
    private $members;

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getListId()
    {
        return $this->listId;
    }

    /**
     * @param mixed $listId
     */
    public function setListId($listId): void
    {
        $this->listId = $listId;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company): void
    {
        $this->company = $company;
    }

    /**
     * @return mixed
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @param mixed $address1
     */
    public function setAddress1($address1): void
    {
        $this->address1 = $address1;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state): void
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param mixed $zip
     */
    public function setZip($zip): void
    {
        $this->zip = $zip;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getPermissionReminder()
    {
        return $this->permissionReminder;
    }

    /**
     * @param mixed $permissionReminder
     */
    public function setPermissionReminder($permissionReminder): void
    {
        $this->permissionReminder = $permissionReminder;
    }

    /**
     * @return mixed
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * @param mixed $fromName
     */
    public function setFromName($fromName): void
    {
        $this->fromName = $fromName;
    }

    /**
     * @return mixed
     */
    public function getFromEmail()
    {
        return $this->fromEmail;
    }

    /**
     * @param mixed $fromEmail
     */
    public function setFromEmail($fromEmail): void
    {
        $this->fromEmail = $fromEmail;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $language
     */
    public function setLanguage($language): void
    {
        $this->language = $language;
    }

    /**
     * @return mixed
     */
    public function getEmailTypeOption()
    {
        return $this->emailTypeOption;
    }

    /**
     * @param mixed $emailTypeOption
     */
    public function setEmailTypeOption($emailTypeOption): void
    {
        $this->emailTypeOption = $emailTypeOption;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'contact' => [
                'company' => $this->company,
                'address1' => $this->address1,
                'city' => $this->city,
                'state' => $this->state,
                'zip' => $this->zip,
                'country' => $this->country
            ],
            'permission_reminder' => $this->permissionReminder,
            'campaign_defaults' => [
                'from_name' => $this->fromName,
                'from_email' => $this->fromEmail,
                'subject' => $this->subject,
                'language' => $this->language
            ],
            'email_type_option' => $this->emailTypeOption
        ];
    }
}
