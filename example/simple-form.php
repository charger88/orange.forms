<?php

require_once __DIR__ . '/autoload.php';

use \Orange\Forms\Fields\Inputs\Text;
use \Orange\Forms\Fields\Inputs\Hidden;
use \Orange\Forms\Fields\Inputs\Date;
use \Orange\Forms\Fields\Inputs\Color;
use \Orange\Forms\Fields\Inputs\Password;
use \Orange\Forms\Fields\Inputs\File;
use \Orange\Forms\Fields\Selectors\Select;
use \Orange\Forms\Fields\Selectors\Radio;
use \Orange\Forms\Fields\Inputs\Textarea;
use \Orange\Forms\Fields\Buttons\Submit;
use \Orange\Forms\Fields\Buttons\Reset;

class SimpleForm extends \Orange\Forms\Form
{

    protected function init($params)
    {

        $this->addField((new Text('name', 'Name'))->setReadonly());
        $this->addField((new Hidden('hidden_field')));
        $this->addField((new Date('birthday', 'Birthday')));
        $this->addField((new Color('color', 'Color')));
        $this->addField((new Password('password', 'Password')));
        $this->addField((new File('file1')));
        $this->addField((new Select('numbers', 'Numbers', [0 => 'Zero', 1 => 'One', 2 => 'Two']))->setEmptyOption(Select::EMPTY_OPTION_ALWAYS));
        $this->addField((new Radio('numbersx', 'Numbers2', [0 => 'Zero', 1 => 'One', 2 => 'Two'])));
        $this->addField((new Textarea('my_text'))->requireField());
        $this->addField((new Submit('my-submit', 'Save')));
        $this->addField((new Reset('my-reset', 'Reset'))->disable());

    }

}

$form = new SimpleForm();
$form->setValues($_POST);

?>
<html>
<head>
    <link href="style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<?php echo $form->getHTML(); ?>
</body>
</html>