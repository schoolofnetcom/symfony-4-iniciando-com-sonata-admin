<?php
/**
 * Created by PhpStorm.
 * User: gilso_nb9zlec
 * Date: 17/03/2018
 * Time: 18:28
 */

namespace App\Admin;


use App\Entity\Author;
use App\Entity\Category;
use App\Entity\Post;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Twig\Node\Expression\Unary\NegUnary;

class PostAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('title', TextType::class, [
            'label' => 'Título'
        ])
            ->add('category', null, [
                'label' => 'Categoria',
                'associated_property' => 'name'
            ])
            ->add('status', 'boolean', [
                'editable' => true,
                'inverse' => true
            ]);
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->tab('Conteúdo')
            ->with('Conteúdo')
                ->add('title', TextType::class)
                ->add('content', TextareaType::class)
                ->add('status', CheckboxType::class, [
                    'required' => false,
                ])
            ->end()
            ->end()
                ->tab('Auxiliar')
            ->with("Auxiliar")
            ->add('category', ModelType::class, [
            'class' => Category::class,
            'property' => 'name',
            'multiple' => true
        ])
            ->add('author', ModelType::class, [
                'class' => Author::class,
                'property' => 'name'
            ])
            ->end()

            ->end();

    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('title')
            ->add('status')
            ->add("category", null, [], EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Categorias'
            ]);
    }

    public function toString($object)
    {
        return $object instanceof Post ? $object->getTitle() : "Postagem";
    }
}