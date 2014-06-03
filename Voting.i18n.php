<?php
/* Language file for mediawiki extension Voting */

$messages = array();

/* English */
$messages['en'] = array(
    /* Extension */
    'voting-credits' => 'Enables multi-criteria customizable rankings of the articles. Provides [[Special:Voting|configuration page]].',
    'voting' => 'Manage votings',
    'voting-specialdescription' => '',
    /* Admin page */
    'voting-specialcolumn-group-id' => 'ID',
    'voting-specialcolumn-group-name' => 'Name',
    'voting-specialcolumn-group-category' => 'Category',
    'voting-specialcolumn-group-active' => 'Status',
    'voting-specialcolumn-group-active-1' => '<b>Active</b>',
    'voting-specialcolumn-group-active-0' => 'Inactive',
    'voting-specialcolumn-group-actions' => 'Actions',
    'voting-speciallink-group-edit' => 'Edit',
    'voting-speciallink-group-delete' => 'Delete',
    /* Menu links */
    'voting-speciallink-create-group' => 'Create new group',
    'voting-speciallink-index' => 'All groups',
    'voting-speciallink-create-rating' => 'Create new rating',
    'voting-speciallink-create-widget-type' => 'Create new widget type',
    'voting-speciallink-view-widget-type' => 'Widget types',
    'voting-speciallink-stat' => 'Statistics',
    /* Group create page */
    'voting-specialgroup-create-title' => 'Create new voting group',
    'voting-specialgroup-create-input-name' => 'Name',
    'voting-specialgroup-create-input-category' => 'Category',
    'voting-specialgroup-create-input-category-help' => 'Voting widget will be shown on these categories',
    'voting-specialgroup-create-input-active' => 'Status',
    'voting-specialgroup-create-input-active-1' => 'Active',
    'voting-specialgroup-create-input-active-0' => 'Inactive',
    'voting-specialgroup-create-input-submit' => 'Create',
    'voting-specialgroup-create-input-title' => 'Title',
    'voting-specialgroup-create-input-title-help' => 'Will be shown to users as widget title',
    'voting-specialgroup-create-input-description' => 'Description',
    'voting-specialgroup-create-input-description-help' => 'Will be shown to users as widget description',
    'voting-specialgroup-create-input-result_message' => 'Result message',
    'voting-specialgroup-create-input-result_message-help' => 'Will be show when user voted',
    /* Assets */
    'voting-js-multiinput-button-add' => '+',
    'voting-js-multiinput-button-remove' => '-',
    'voting-error-input-common' => 'You have errors in you input. Check form.',
    'voting-js-select-control-null' => 'Choose option',
    'voting-js-link-confirm-delete' => 'Are you sure ?',
    /* Group edit page */
    'voting-specialgroup-edit-title' => 'Edit $1 group.',
    'voting-specialgroup-edit-input-submit' => 'Save',
    /* Group view page */
    'voting-specialgroup-view-title' => 'Group $1 ratings list',
    'voting-specialcolumn-rating-id' => 'ID',
    'voting-specialcolumn-rating-name' => 'Name',
    'voting-specialcolumn-rating-type' => 'Widget',
    'voting-specialcolumn-rating-actions' => 'Actions',
    'voting-specialcolumn-rating-description' => 'Description',
    /* Rating create page */
    'voting-specialrating-create-title' => 'Create new rating',
    'voting-specialrating-create-input-name' => 'Name',
    'voting-specialrating-create-input-group' => 'Group',
    'voting-specialrating-create-input-desc' => 'Description',
    'voting-specialrating-create-input-typevalues-help' => 'This values can be selected by user as his vote',
    'voting-specialrating-create-input-typevalues' => 'Type value',
    'voting-specialrating-create-input-typeid' => 'Widget type',
    'voting-specialrating-create-input-typeid-0' => 'Stars',
    'voting-specialrating-create-input-typeid-1' => 'Select',
    'voting-specialrating-create-input-typeid-2' => 'Switch',
    'voting-specialrating-create-input-typeid-3' => 'Checkboxes',
    'voting-specialrating-create-input-typeid-edit' => 'Edit this type',
    'voting-specialrating-edit-title' => 'Edit $1 rating',
    'voting-voting-specialrating-create-notypes' => 'Не создано ни одного типа виджета, ',
    'voting-voting-specialrating-create-notypes-1' => 'создайте один сейчас',
    /* Widget type view page */
    'voting-specialtype-view-title' => 'List of widget types',
    'voting-specialcolumn-type-id' => 'ID',
    'voting-specialcolumn-type-name' => 'Name',
    'voting-specialcolumn-type-control-id' => 'Element',
    'voting-specialcolumn-type-control-actions' => 'Actions',
    /* Widget type create page */
    'voting-specialtype-create-title' => 'Create new widget type',
    'voting-specialtype-create-input-name' => 'Name',
    'voting-specialtype-create-input-control-id' => 'Control type',
    'voting-specialtype-create-input-control-id-0' => 'Stars',
    'voting-specialtype-create-input-control-id-1' => 'Select',
    'voting-specialtype-create-input-control-id-2' => 'Switch',
    'voting-specialtype-create-input-control-id-3' => 'Checkboxes',
    'voting-specialtype-create-input-control-id-4' => 'Circles',
    'voting-specialtype-create-input-values' => 'Values',
    'voting-specialtype-create-input-values-title' => 'Title',
    'voting-specialtype-create-input-values-value' => 'Value (int)',
    'voting-specialtype-edit-title' => 'Edit $1 widget type',
    /* Stat page */
    'voting-specialstat-title' => 'Statistics',
    'voting-widget-send-votes' => 'Vote!',
    /* RC log */
    'voting-log-action-wv_vote' => 'Voted',
    'voting-log-action-wv_change' => 'Changed vote',
    'voting-log-comment' => '$1',
	/* Types */
	'voting-type-create-0' => 'Number',
	'voting-type-create-1' => 'Stars',
	'voting-type-create-2' => 'Scale',
	'voting-type-create-3' => 'Weighted',
	'voting-specialtype-type-display-title' => 'Display settings',
	'voting-widget-vote-history' => 'Voting history'
);

/* Russian */
$messages['ru'] = array(
    /* Extension */
    'voting-credits' => 'Расширение позволяет администраторам создавать различные настраиваемые голосования, а пользователям - голосовать за страницы.',
    'voting' => 'Управление голосованиями',
    'voting-specialdescription' => 'Управляйте голосованиями для страниц. Организуйте группы голосований, включающие наборы оценок.',
    /* Admin page */
    'voting-specialcolumn-group-id' => 'ID',
    'voting-specialcolumn-group-name' => 'Название',
    'voting-specialcolumn-group-category' => 'Категория',
    'voting-specialcolumn-group-active' => 'Статус',
    'voting-specialcolumn-group-active-1' => '<b>Активна</b>',
    'voting-specialcolumn-group-active-0' => 'Неактивна',
    'voting-specialcolumn-group-actions' => 'Действия',
    'voting-speciallink-group-edit' => 'Править',
    'voting-speciallink-group-delete' => 'Удалить',
    /* Menu links */
    'voting-speciallink-create-group' => 'Создать новую группу',
    'voting-speciallink-index' => 'Список групп',
    'voting-speciallink-create-rating' => 'Создать новый рейтинг',
    'voting-speciallink-create-widget-type' => 'Создать тип виджета',
    'voting-speciallink-view-widget-type' => 'Типы виджетов',
    'voting-speciallink-stat' => 'Статистика',
    'voting-speciallink-rules' => 'Правила видимости',
    /* Group create page */
    'voting-specialgroup-create-title' => 'Создать новую группу',
    'voting-specialgroup-create-input-name' => 'Название группы',
    'voting-specialgroup-create-input-category' => 'Категория группы',
    'voting-specialgroup-create-input-category-help' => 'Виджет голосования будет отображен для этих категорий страниц',
    'voting-specialgroup-create-input-active' => 'Статус',
    'voting-specialgroup-create-input-active-1' => 'Активна',
    'voting-specialgroup-create-input-active-0' => 'Неактивна',
    'voting-specialgroup-create-input-submit' => 'Создать',
    'voting-specialgroup-create-input-title' => 'Заголовок',
    'voting-specialgroup-create-input-title-help' => 'Будет показан пользователям как заголовок виджета',
    'voting-specialgroup-create-input-description' => 'Описане',
    'voting-specialgroup-create-input-description-help' => 'Будет показано пользователям под заголовком виджета',
    'voting-specialgroup-create-input-result_message' => 'Сообщение',
    'voting-specialgroup-create-input-result_message-help' => 'Будет показано пользователю после голосования',
    'voting-specialrating-edit-title' => 'Редактировать рейтинг $1',
    'voting-specialgroup-input-rule' => 'Правило видимости',
    /* Assets */
    'voting-js-multiinput-button-add' => '+',
    'voting-js-multiinput-button-remove' => '-',
    'voting-error-input-common' => 'Ошибка заполнения полей. Проверьте форму.',
    'voting-js-select-control-null' => 'Выберите вариант',
    'voting-js-link-confirm-delete' => 'Вы уверены ?',
    'voting-js-view-format-yesno-no' => 'Отрицательно',
    'voting-js-view-format-yesno-yes' => 'Положительно',
    /* Group edit page */
    'voting-specialgroup-edit-title' => 'Редактирование группы $1.',
    'voting-specialgroup-edit-input-submit' => 'Сохранить',
    /* Group view page */
    'voting-specialgroup-view-title' => 'Рейтинги группы $1',
    'voting-specialcolumn-rating-id' => 'ID',
    'voting-specialcolumn-rating-name' => 'Название',
    'voting-specialcolumn-rating-type' => 'Виджет',
    'voting-specialcolumn-rating-actions' => 'Действия',
    'voting-specialcolumn-rating-description' => 'Описание',
    /* Rating create page */
    'voting-specialrating-create-title' => 'Создать новый рейтинг',
    'voting-specialrating-create-input-name' => 'Название',
    'voting-specialrating-create-input-group' => 'Группа',
    'voting-specialrating-create-input-desc' => 'Описание',
    'voting-specialrating-create-input-typevalues-help' => 'Эти значения будут предложены пользователю как выбор его голоса.',
    'voting-specialrating-create-input-typevalues' => 'Значение',
    'voting-specialrating-create-input-typeid' => 'Тип виджета',
    'voting-specialrating-create-input-typeid-0' => 'Звезды',
    'voting-specialrating-create-input-typeid-1' => 'Выбор',
    'voting-specialrating-create-input-typeid-2' => 'Переключатель',
    'voting-specialrating-create-input-typeid-3' => 'Чекбоксы',
	'voting-specialtype-create-input-control-id-4' => 'Кружочки',
    'voting-specialrating-create-input-typeid-edit' => 'Редактировать тип виджета',
    'voting-voting-specialrating-create-notypes' => 'There are no widget types ',
    'voting-voting-specialrating-create-notypes-1' => 'create one now',
    /* Widget type view page */
    'voting-specialtype-view-title' => 'Список типов виджета',
    'voting-specialcolumn-type-id' => 'ID',
    'voting-specialcolumn-type-name' => 'Название',
    'voting-specialcolumn-type-control-id' => 'Элемент',
    'voting-specialcolumn-type-control-actions' => 'Действия',
    /* Widget type create page */
    'voting-specialtype-create-title' => 'Создать новый тип виджета',
    'voting-specialtype-create-input-name' => 'Название',
    'voting-specialtype-create-input-control-id' => 'Тип элемента',
    'voting-specialtype-create-input-control-id-0' => 'Звезды',
    'voting-specialtype-create-input-control-id-1' => 'Выбор',
    'voting-specialtype-create-input-control-id-2' => 'Переключатель',
    'voting-specialtype-create-input-control-id-3' => 'Чекбоксы',
    'voting-specialtype-create-input-values' => 'Значения',
    'voting-specialtype-create-input-values-title' => 'Название',
    'voting-specialtype-create-input-values-value' => 'Значение (число)',
    'voting-specialtype-edit-title' => 'Редактировать тип $1',
    /* Stat page */
    'voting-specialstat-title' => 'Статистика',
    /* Rules view page */
    'voting-specialrules-view-title' => 'Список правил видимости',
    'voting-speciallink-create-rule' => 'Создать правило видимости',
    'voting-specialrule-create-title' => 'Создание правила видимости',
    'voting-specialrule-create-input-name' => 'Название',
    'voting-specialrule-create-input-groups-title' => 'Группы видимости',
    /* Rule edit page */
    'voting-specialrule-edit-title' => 'Редактирование группы видимости $1',
    'voting-widget-send-votes' => 'Голосовать',
    /* RC log */
    'voting-log-action-wv_vote' => 'оценил страницу',
    'voting-log-action-wv_change' => 'изменил оценку страницы',
    'voting-log-comment' => '$1',
	/* Types */
    'voting-type-create-0' => 'Число',
    'voting-type-create-1' => 'Звезды',
    'voting-type-create-2' => 'Шкала',
    'voting-type-create-3' => 'Больше-меньше',
	'voting-specialtype-type-display-title' => 'Настройка отображения',
	'voting-widget-vote-history' => 'История голосований'
);
