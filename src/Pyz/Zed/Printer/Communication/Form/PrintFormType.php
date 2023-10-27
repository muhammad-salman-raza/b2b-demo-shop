<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\Printer\Communication\Form;

use Generated\Shared\Transfer\PrinterTransfer;
use Generated\Shared\Transfer\PrintRequestTransfer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use function base64_encode;
use function file_get_contents;
use function parse_url;
use function pathinfo;

/**
 * @method \Pyz\Zed\Printer\Communication\PrinterCommunicationFactory getFactory()
 * @method \Pyz\Zed\Printer\PrinterConfig getConfig()
 * @method \Pyz\Zed\Printer\Business\PrinterFacadeInterface getFacade()
 */
class PrintFormType extends AbstractType
{
    /**
     * @var string
     */
    public const KEY_UPLOADED_FILE = 'uploadedFile';

    /**
     * @var string
     */
    public const KEY_URI = 'uri';

    /**
     * @var string
     */
    private const VALUE_PDF_URI = 'pdf_uri';

    /**
     * @var string
     */
    private const VALUE_RAW_URI = 'raw_uri';

    /**
     * @var string
     */
    private const VALUE_PDF_FILE = 'pdf_base64';

    /**
     * @var string
     */
    private const VALUE_RAW_FILE = 'raw_base64';

    /**
     * @var string[]
     */
    private const FILE_OPTIONS = [
        self::VALUE_PDF_FILE,
        self::VALUE_RAW_FILE,
    ];

    /**
     * @var string[]
     */
    private const URI_OPTIONS = [
        self::VALUE_PDF_URI,
        self::VALUE_RAW_URI,
    ];

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this
            ->addPrinterField($builder, $options)
            ->addContentTypeField($builder, $options)
            ->addUriField($builder, $options)
            ->addUploadFileField($builder, $options)
            ->addQuantityField($builder, $options)
            ->addSubmitButtonField($builder, $options)
            ->addFormSubmitEventListner($builder, $options);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return $this
     */
    private function addFormSubmitEventListner(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            /** @var \Generated\Shared\Transfer\PrintRequestTransfer $printRequestTransfer */
            $printRequestTransfer = $event->getData();
            $uploadedFile = $form[self::KEY_UPLOADED_FILE]?->getData();
            $uri = $form[self::KEY_URI]?->getData();

            if (in_array($printRequestTransfer->getContentType(), self::FILE_OPTIONS) && $uploadedFile) {
                $this->setContentAndTitleFromUploadedFile($uploadedFile, $printRequestTransfer);
            } elseif (in_array($printRequestTransfer->getContentType(), self::URI_OPTIONS) && $uri) {
                $this->setContentAndTitleFromURI($uri, $printRequestTransfer);
            }

            $event->setData($printRequestTransfer);
        });

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return $this
     */
    private function addPrinterField(FormBuilderInterface $builder, array $options)
    {
        $builder->add(PrintRequestTransfer::PRINTER, ChoiceType::class, [
            'label' => 'printer.form.label.printer',
            'choices' => $options['printers'],
            'choice_label' => fn (PrinterTransfer $printer, $key, $value) => $printer->getName() . '(' . $printer->getComputer()?->getName() . ')',
            'choice_value' => fn (?PrinterTransfer $printer = null) => $printer ? $printer->getPrinterId() : '',
            'constraints' => [
                new NotBlank([
                    'message' => 'printer.form.error.printer.blank',
                ]),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return $this
     */
    private function addQuantityField(FormBuilderInterface $builder, array $options)
    {
        $builder->add(PrintRequestTransfer::QTY, IntegerType::class, [
            'label' => 'printer.form.label.quantity',
            'required' => true,
            'constraints' => [
                new NotBlank([
                    'message' => 'printer.form.error.quantity.blank',
                ]),
                new GreaterThan([
                    'value' => 0,
                    'message' => 'printer.form.error.printer.negative',
                ]),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return $this
     */
    private function addUriField(FormBuilderInterface $builder, array $options)
    {
        $builder->add(self::KEY_URI, TextType::class, [
            'label' => 'printer.form.label.uri',
            'required' => false,
            'mapped' => false,
            'constraints' => [
                new Callback(fn ($value, ExecutionContextInterface $context) => $this->validateUri($value, $context)),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return $this
     */
    private function addContentTypeField(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(PrintRequestTransfer::CONTENT_TYPE, ChoiceType::class, [
                'choices' => [
                    'Pdf URI' => self::VALUE_PDF_URI,
                    'Raw URI' => self::VALUE_RAW_URI,
                    'Pdf File' => self::VALUE_PDF_FILE,
                    'Raw File' => self::VALUE_RAW_FILE,
                ],
                'expanded' => true,
                'multiple' => false,
                'attr' => ['class' => 'printer__content-type-wrapper'],
                'choice_attr' => fn (string $choice, string $key, string $value) => ['class' => 'printer__form-check'],
            ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return $this
     */
    private function addUploadFileField(FormBuilderInterface $builder, array $options)
    {
        $builder->add(self::KEY_UPLOADED_FILE, FileType::class, [
            'label' => 'printer.form.label.file',
            'mapped' => false,
            'required' => false,
            'constraints' => [
                new Callback(fn ($value, ExecutionContextInterface $context) => $this->validateFile($value, $context)),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return $this
     */
    private function addSubmitButtonField(FormBuilderInterface $builder, array $options)
    {
        $builder->add('print', SubmitType::class, [
            'label' => 'printer.form.label.submit',
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PrintRequestTransfer::class,
            'printers' => [],
        ]);
    }

    /**
     * @param string|null $value
     * @param \Symfony\Component\Validator\Context\ExecutionContextInterface $context
     *
     * @return void
     */
    private function validateUri(?string $value, ExecutionContextInterface $context): void
    {
        $form = $context->getRoot();

        /** @var \Generated\Shared\Transfer\PrintRequestTransfer $printRequestTransfer */
        $printRequestTransfer = $form->getData();

        if (in_array($printRequestTransfer->getContentType(), self::URI_OPTIONS) && !$value) {
            $context->buildViolation('printer.form.error.uri.blank')
                ->atPath(self::KEY_URI)
                ->addViolation();
        }
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile|null $value
     * @param \Symfony\Component\Validator\Context\ExecutionContextInterface $context
     *
     * @return void
     */
    private function validateFile(?UploadedFile $value, ExecutionContextInterface $context): void
    {
        $form = $context->getRoot();

        /** @var \Generated\Shared\Transfer\PrintRequestTransfer $printRequestTransfer */
        $printRequestTransfer = $form->getData();

        if (in_array($printRequestTransfer->getContentType(), self::FILE_OPTIONS) && !$value) {
            $context->buildViolation('printer.form.error.file.blank')
                ->atPath(self::KEY_UPLOADED_FILE)
                ->addViolation();
        }
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    private function getTitleFromURI(string $uri): string
    {
        $parsedUrl = parse_url($uri);

        if (!isset($parsedUrl['path'])) {
            return '';
        }

        return basename($parsedUrl['path']);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
     * @param \Generated\Shared\Transfer\PrintRequestTransfer $printRequestTransfer
     *
     * @return void
     */
    private function setContentAndTitleFromUploadedFile(UploadedFile $uploadedFile, PrintRequestTransfer $printRequestTransfer): void
    {
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $content = file_get_contents($uploadedFile->getRealPath());
        $fileContent = $content ? base64_encode($content) : '';

        $printRequestTransfer
            ->setTitle($originalFilename)
            ->setContent($fileContent);
    }

    /**
     * @param string $uri
     * @param \Generated\Shared\Transfer\PrintRequestTransfer $printRequestTransfer
     *
     * @return void
     */
    private function setContentAndTitleFromURI(string $uri, PrintRequestTransfer $printRequestTransfer): void
    {
        $printRequestTransfer
            ->setTitle($this->getTitleFromURI($uri))
            ->setContent($uri);
    }
}
