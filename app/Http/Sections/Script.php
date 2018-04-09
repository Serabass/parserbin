<?php

namespace Parserbin\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminDisplay;
use AdminFormElement;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class Script.
 *
 * @property \Parserbin\Models\Script $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Script extends Section
{
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $alias;

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync();
        $display->setColumns([
            AdminColumnEditable::text('content')->setLabel('Скрипт'),
            AdminColumn::text('parser.title')->setLabel('Парсер'),
            AdminColumn::datetime('created_at')
                ->setLabel('Создан')
                ->setFormat('d.m.Y h:i:s'),

            AdminColumn::datetime('updated_at')
                ->setLabel('Обновлён')
                ->setFormat('d.m.Y h:i:s'),
        ]);

        return $display;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $form = \AdminForm::form();
        $form->setElements([
            AdminFormElement::textarea('content', 'Скрипт'),
            AdminFormElement::selectajax('parserId', 'Парсер')
                ->setModelForOptions(\Parserbin\Models\Parser::class),
            AdminFormElement::selectajax('languageId', 'Язык')
                ->setModelForOptions(\Parserbin\Models\Language::class),
        ]);

        return $form;
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }

    /**
     * @return void
     */
    public function onDelete($id)
    {
        // remove if unused
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }
}
