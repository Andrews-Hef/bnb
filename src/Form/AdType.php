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
     * @return array
     */
private function getConfiguration($label,$placeholder){
  return[
        'label'=> $label,
        'attr' => [
            'placeholder' => $placeholder
        ]
    ];

}

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Titre","Tapez un super titre !"))
            ->add('slug', TextType::class,$this->getConfiguration("Adresse web","Tapez l'adressse web (automatique)"))
            ->add('price', MoneyType::class,$this->getConfiguration("Prix par nuit","indiquez le prix que vous voulez pour une nuit") )
            ->add('introduction',TextType::class,$this->getConfiguration("introduction","donnez une description globale de l'annonce"))
            ->add('content',TextareaType::class, $this->getConfiguration("description detaillé","tapez une description qui donne vriament envie de venir chez vous!"))
            ->add('coverImage', UrlType::class, $this->getConfiguration("URL de l'image","donnez une jolie image") )
            ->add('rooms', IntegerType::class,$this->getConfiguration("nombre de chambrs","le nombre de chambes disponible ") )
            ->add('images',CollectionType::class,[
              'entry_type'=>  ImageType::class,
              'allow_add'=> true 
              
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
