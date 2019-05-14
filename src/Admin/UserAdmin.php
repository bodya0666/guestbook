<?php

namespace App\Admin;

use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class UserAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('email', EmailType::class)
            ->add('username', TextType::class)
            ->add('baned', CheckboxType::class, ['label' => 'Ban', 'required' => false])
            ->add('captchaCode', CaptchaType::class, [
                'captchaConfig' => 'ExampleCaptcha'
            ])

            ->add('password', HiddenType::class)
            ->add('plainPassword', HiddenType::class, ['data' => 'plainPassword'])
            ->add('user_agent', HiddenType::class)
            ->add('ip', HiddenType::class)

        ;
    }
    public function prePersist($image)
    {
        $this->manageFileUpload($image);

    }

    public function preUpdate($image)
    {
        $this->manageFileUpload($image);

    }

    private function manageFileUpload($image)
    {

    }
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email')
            ->add('username')
            ->add('user_agent')
            ->add('ip')
            ->add('baned')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('email')
            ->addIdentifier('username')
            ->addIdentifier('user_agent')
            ->addIdentifier('ip')
            ->addIdentifier('baned')
        ;
    }
}
