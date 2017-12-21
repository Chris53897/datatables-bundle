<?php

/*
 * Symfony DataTables Bundle
 * (c) Omines Internetbureau B.V. - https://omines.nl/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Omines\DataTablesBundle\Column;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig_Environment;

/**
 * TwigColumn.
 *
 * @author Niels Keurentjes <niels.keurentjes@omines.com>
 */
class TwigColumn extends AbstractColumn
{
    /** @var Twig_Environment */
    private $twig;

    /**
     * TwigColumn constructor.
     *
     * @param Twig_Environment|null $twig
     */
    public function __construct(Twig_Environment $twig = null)
    {
        if (null === ($this->twig = $twig)) {
            throw new \LogicException('You must have TwigBundle installed to use ' . self::class);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function render($value, $context)
    {
        return $this->twig->render($this->getTemplate(), [
            'row' => $context,
            'value' => $value,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($value)
    {
        return $value;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver
            ->setRequired('template')
            ->setAllowedTypes('template', 'string')
        ;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->options['template'];
    }
}
