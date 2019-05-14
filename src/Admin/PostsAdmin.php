<?php

namespace App\Admin;

use App\Entity\Posts;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;


final class PostsAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->add('username', TextType::class)
            ->add('email', EmailType::class)
            ->add('homepage', TextType::class, ['required' => false])
            ->add('text', TextareaType::class)
            ->add('alt_text', TextareaType::class, ['required' => false])
            ->add('image', HiddenType::class, ['required' => false])
            ->add('file', FileType::class, ['required' => false, 'data' => null, 'mapped' => false])
            ->add('status', CheckboxType::class, ['label' => 'Show', 'required' => false])
            ->add('date', HiddenType::class, ['data' => date('Y-m-d H:i:s')])
            ->add('captchaCode', CaptchaType::class, [
                'captchaConfig' => 'ExampleCaptcha'
            ])

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
        $dir = __DIR__ . '/../../public/uploads/images/';
       // var_dump($_FILES);
        if (count($_FILES) > 0) {
            foreach ($_FILES as $key => $value)
            {
                $name = md5(uniqid()) . '.png';
                $tmp_name = $value['tmp_name']['file'];
                if ($tmp_name) {
                    move_uploaded_file($tmp_name, $dir . $name);
                    $image->setImage($name);
                }
            }
        }
    }
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('username')
            ->add('email')
            ->add('homepage')
            ->add('alt_text')
            ->add('status')
            ->add('image')
            ->add('date')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('username')
            ->addIdentifier('email')
            ->addIdentifier('homepage')
            ->addIdentifier('alt_text')
            ->addIdentifier('status')
            ->addIdentifier('image')
            ->addIdentifier('date')
        ;
    }
}
