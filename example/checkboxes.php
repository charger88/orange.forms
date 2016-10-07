<?php

require_once __DIR__ . '/autoload.php';

use \Orange\Forms\Fields\Selectors\Checkbox;
use \Orange\Forms\Components\Fieldset;
use \Orange\Forms\Fields\Buttons\Submit;

class SimpleForm extends \Orange\Forms\Form
{

    protected function init($params)
    {

        $this->addField((new Fieldset('just-fieldset', 'My fieldset'))
            ->addField((new Checkbox('option_1', 'Option 1'))->setName('option[]')->setDefault(1))
            ->addField((new Checkbox('option_2', 'Option 2'))->setName('option[]')->setDefault(2))
            ->addField((new Checkbox('option_3', 'Option 3'))->setName('option[]')->setDefault(3))
        );
        $this->addField((new Submit('my-submit', 'Save')));

    }

}

$form = new SimpleForm();
$form->setValues($_POST);

?>
<html>
<head>
</head>
<body>
<?php echo $form->getHTML(); ?>
</body>
</html>