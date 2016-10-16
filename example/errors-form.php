<?php

require_once __DIR__ . '/autoload.php';

use \Orange\Forms\Fields\Inputs\Text;
use \Orange\Forms\Fields\Inputs\Hidden;
use \Orange\Forms\Fields\Inputs\Date;
use \Orange\Forms\Fields\Inputs\Color;
use \Orange\Forms\Fields\Inputs\Password;
use \Orange\Forms\Fields\Inputs\File;
use \Orange\Forms\Fields\Selectors\Checkbox;
use \Orange\Forms\Fields\Selectors\Select;
use \Orange\Forms\Fields\Selectors\Radio;
use \Orange\Forms\Fields\Inputs\Textarea;
use \Orange\Forms\Fields\Buttons\Submit;
use \Orange\Forms\Fields\Buttons\Reset;
use \Orange\Forms\Fields\Html;

class SimpleForm extends \Orange\Forms\Form
{

    protected function init($params)
    {

        $this->addField((new Text('name', 'Name'))->requireField());
        $this->addField((new Text('surname', 'Surname'))->requireField());
        $this->addField((new Submit('my-submit', 'Save')));
        $this->addField((new Reset('my-reset', 'Reset'))->disable());

    }

}

$form = new SimpleForm();
$errors = $form->validateValues()->getErrors();

?>
<html>
<head>
    <style>
        .orange-forms-field-errors {
            color: red;
        }
    </style>
</head>
<body>
<p>Errors: <?php echo implode(', ', array_map(function($item){
        return implode(', ', $item);
    }, $errors)); ?></p>
</body>
</html>