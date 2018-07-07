<?php

namespace Parserbin\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminColumnFilter;
use AdminDisplay;
use AdminFormElement;
use Illuminate\Support\Facades\URL;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class Parser.
 *
 * @property \Parserbin\Models\Parser $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Parser extends Section
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
            AdminColumnEditable::text('title')->setLabel('Название'),
            AdminColumnEditable::text('hash')->setLabel('Хеш'),
            AdminColumn::datetime('created_at')
                ->setLabel('Создан')
                ->setFormat('d.m.Y h:i:s'),

            AdminColumn::datetime('updated_at')
                ->setLabel('Обновлён')
                ->setFormat('d.m.Y h:i:s'),
        ]);

        $display->setColumnFilters([
            AdminColumnFilter::text()
                ->setColumnName('title')
                ->setPlaceholder('Название')
                ->setOperator('contains'),

            AdminColumnFilter::text()
                ->setColumnName('hash')
                ->setPlaceholder('Хеш')
                ->setOperator('contains'),

        ]);

        $display->getColumnFilters()
            ->setPlacement('panel.heading');

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
            AdminFormElement::text('title', 'Название'),
            $id ? AdminFormElement::textaddon('hash', 'Хеш')
                ->required(true)
                ->setAddon(URL::to('/p/').'/') : null,

            AdminFormElement::selectajax('user_id', 'Пользователь')
                ->setModelForOptions(\Parserbin\User::class),

            AdminFormElement::textarea('input', 'Входящие данные'),
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
