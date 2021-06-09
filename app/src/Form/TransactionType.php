<?php
/**
 * Transaction type.
 */

namespace App\Form;

use App\Entity\Category;
use App\Entity\Transaction;
use App\Entity\Wallet;
use App\Entity\Payment;
use App\Entity\Operation;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TransactionType.
 */
class TransactionType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder The form builder
     * @param array                                        $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'name',
            TextType::class,
            [
                'label' => 'label_name',
                'required' => true,
                'attr' => ['max_length' => 64],
            ]
        );
        $builder->add(
            'date',
            Data::class,
            [
                'label' => 'label_date',
                'required' => true,
            ]
        );
        $builder->add(
            'amount',
            Integer::class,
            [
                'label' => 'label_amount',
                'required' => true,
            ]
        );
        $builder->add(
            'category',
            EntityType::class,
            [
                'class' => Category::class,
                'choice_label' => function ($category) {
                    return $category->getName();
                },
                'label' => 'label_id_category',
                'placeholder' => 'label_none',
                'required' => true,
            ]
        );
        $builder->add(
            'wallet',
            EntityType::class,
            [
                'class' => Wallet::class,
                'choice_label' => function ($wallet) {
                    return $wallet->getName();
                },
                'label' => 'label_id_wallet',
                'placeholder' => 'label_none',
                'required' => true,
            ]
        );
        $builder->add(
            'payment',
            EntityType::class,
            [
                'class' => Payment::class,
                'choice_label' => function ($payment) {
                    return $payment->getName();
                },
                'label' => 'label_id_payment',
                'placeholder' => 'label_none',
                'required' => true,
            ]
        );
        $builder->add(
            'operation',
            EntityType::class,
            [
                'class' => Operation::class,
                'choice_label' => function ($operation) {
                    return $operation->getName();
                },
                'label' => 'label_id_operation',
                'placeholder' => 'label_none',
                'required' => true,
            ]
        );
    }

    /**
     * Configures the options for this type.
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Transaction::class]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'transaction';
    }
}