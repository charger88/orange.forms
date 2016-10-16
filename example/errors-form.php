<?php

require_once __DIR__ . '/autoload.php';

use \Orange\Forms\Fields\Inputs\Text;
use \Orange\Forms\Fields\Buttons\Submit;
use \Orange\Forms\Components\Fieldset;

class SimpleForm extends \Orange\Forms\Form
{

    protected function init($params)
    {

        $this->addField((new Text('name', 'Name'))->requireField());
        $this->addField((new Text('surname', 'Surname'))->requireField());
        $this->addField((new Fieldset('books', 'Books'))
            ->addField((new Text('title', 'Title'))->requireField())
        );
        $this->addField((new Submit('my-submit', 'Save')));

    }

}

$form = new SimpleForm();
$form->setValues($_POST);
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

<?php echo $form->getHTML(); ?>

</body>
</html>