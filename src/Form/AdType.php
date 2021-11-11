<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\Image;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\DBAL\Types\TextType as DoctrineTextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdType extends AbstractType
{

    /**
     * permet d'avoir la configurtion de base dun champ
     * 
     *
     * @param [type] $label
     * @param [type] $placeholder
     * @param array $options
     * @return array
     */
private function getConfiguration($label,$placeholder, $options= []){
  return array_merge([
        'label'=> $label,
        'attr' => [
            'placeholder' => $placeholder
        ]
    ], $options);

}

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Titre","Tapez un super titre !"))
            ->add('slug', TextType::class,$this->getConfiguration("Adresse web","Tapez l'adressse web (automatique)",[
                'required'=> false
            ]))
            ->add('price', MoneyType::class,$this->getConfiguration("Prix par nuit","indiquez le prix que vous voulez pour une nuit") )
            ->add('introduction',TextType::class,$this->getConfiguration("introduction","donnez une description globale de l'annonce"))
            ->add('content',TextareaType::class, $this->getConfiguration("description detaillé","tapez une description qui donne vriament envie de venir chez vous!"))
            ->add('coverImage', UrlType::class, $this->getConfiguration("URL de l'image","images principal de l'annonce ") )
            ->add('rooms', IntegerType::class,$this->getConfiguration("nombre de chambres","le nombre de chambes disponible ") )
            ->add('images',CollectionType::class,[
              'entry_type'=>  ImageType::class,
              'allow_add'=> true,
              'allow_delete'=> true
              
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
